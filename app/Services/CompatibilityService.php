<?php

namespace App\Services;

class CompatibilityService
{
    /**
     * Check compatibility between Motherboards and CPUs.
     *
     * @param array $motherboards Array of motherboard details.
     * @param array $cpus Array of CPU details.
     * @return array Compatibility blocks.
     */
    public function checkMotherboardCpu(array $motherboards, array $cpus): array
    {
        $results = [];
        foreach ($motherboards as $mb) {
            foreach ($cpus as $cpu) {
                $compatible = strtolower($mb['socket_type']) === strtolower($cpu['socket_type']);
                $results[] = [
                    'block' => 'Motherboard - CPU',
                    'motherboard' => $mb,
                    'cpu' => $cpu,
                    'compatible' => $compatible,
                    'message' => $compatible
                    ? "The motherboard \"{$mb['name']}\" and the CPU \"{$cpu['name']}\" are compatible based on their matching socket type \"{$mb['socket_type']}\"."
                    : "The CPU \"{$cpu['name']}\" uses a \"{$cpu['socket_type']}\" socket which does not match the motherboard \"{$mb['name']}\" socket type \"{$mb['socket_type']}\".",

                ];
            }
        }
        return $results;
    }

    /**
     * Check compatibility between CPUs and Coolers.
     *
     * @param array $cpus Array of CPU details.
     * @param array $coolers Array of Cooler details.
     * @return array Compatibility blocks.
     */
    public function checkCpuCooler(array $cpus, array $coolers): array
    {
        $results = [];
        foreach ($cpus as $cpu) {
            foreach ($coolers as $cooler) {
                // Ensure the CPU's socket is among the cooler's supported sockets.
                $supportedSockets = array_map('strtolower', $cooler['supported_sockets'] ?? []);
                $compatible = in_array(strtolower($cpu['socket_type']), $supportedSockets);
                $results[] = [
                    'block' => 'CPU - Cooler',
                    'cpu' => $cpu,
                    'cooler' => $cooler,
                    'compatible' => $compatible,
                    'message' => $compatible
                    ? "The cooler \"{$cooler['name']}\" supports the CPU socket \"{$cpu['socket_type']}\", making it compatible with the CPU \"{$cpu['name']}\"."
                    : "The cooler \"{$cooler['name']}\" does not support the socket type \"{$cpu['socket_type']}\" required by CPU \"{$cpu['name']}\".",

                ];
            }
        }
        return $results;
    }

    /**
     * Check compatibility between Motherboards and Storage devices.
     *
     * Here we assume that each storage device requires one connector.
     *
     * @param array $motherboards Array of motherboard details.
     * @param array $storages Array of Storage device details.
     * @return array Compatibility blocks.
     */
    public function checkMotherboardStorage(array $motherboards, array $storages): array
    {
        $results = [];
        foreach ($motherboards as $mb) {
            $sataCount = 0;
            $m2Count = 0;
            // Count storage devices by connector type.
            foreach ($storages as $storage) {
                if (isset($storage['connector_type'])) {
                    $type = strtolower($storage['connector_type']);
                    if ($type === 'sata') {
                        $sataCount++;
                    } elseif ($type === 'm2') {
                        $m2Count++;
                    }
                }
            }
            $compatible = ($sataCount <= $mb['sata_storage_connectors']) && ($m2Count <= $mb['m2_storage_connectors']);
            $message = "SATA drives: $sataCount/{$mb['sata_storage_connectors']}, M.2 drives: $m2Count/{$mb['m2_storage_connectors']}";
            $results[] = [
                'block' => 'Motherboard - Storage',
                'motherboard' => $mb,
                'storage' => $storages, // In this block, all storage devices are compared against the motherboard.
                'compatible' => $compatible,
                'message' => $compatible
                ? "All storage devices in the basket can be connected to the motherboard \"{$mb['name']}\". {$sataCount} SATA and {$m2Count} M.2 devices fit within the available {$mb['sata_storage_connectors']} SATA and {$mb['m2_storage_connectors']} M.2 slots."
                : "The motherboard \"{$mb['name']}\" lacks sufficient connectors. You need {$sataCount} SATA and {$m2Count} M.2, but only {$mb['sata_storage_connectors']} SATA and {$mb['m2_storage_connectors']} M.2 connectors are available.",

            ];
        }
        return $results;
    }

    /**
     * Check compatibility between Motherboards and GPUs.
     *
     * For now, this is a placeholder—more detailed logic (like PCIe slot types) can be added later.
     *
     * @param array $motherboards Array of motherboard details.
     * @param array $gpus Array of GPU details.
     * @return array Compatibility blocks.
     */
    public function checkMotherboardGpu(array $motherboards, array $gpus): array
    {
        $results = [];
        foreach ($motherboards as $mb) {
            foreach ($gpus as $gpu) {
                $results[] = [
                    'block' => 'Motherboard - GPU',
                    'motherboard' => $mb,
                    'gpu' => $gpu,
                    'compatible' => true, // Defaulting to true; enhance as needed.
                    'message' => "Due to standard PCIe compatibility, the GPU \"{$gpu['name']}\" should be compatible with the motherboard \"{$mb['name']}\". Please verify physical slot and case size separately.",
];
            }
        }
        return $results;
    }

    /**
     * Check compatibility between Motherboards and RAM.
     *
     * @param array $motherboards Array of motherboard details.
     * @param array $rams Array of RAM details.
     * @return array Compatibility blocks.
     */
    public function checkMotherboardRam(array $motherboards, array $rams): array
    {
        $results = [];
        foreach ($motherboards as $mb) {
            foreach ($rams as $ram) {
                $compatible = strtolower($mb['ram_type']) === strtolower($ram['ram_type']);
                $results[] = [
                    'block' => 'Motherboard - RAM',
                    'motherboard' => $mb,
                    'ram' => $ram,
                    'compatible' => $compatible,
                    'message' => $compatible
                    ? "The RAM module \"{$ram['name']}\" is compatible with motherboard \"{$mb['name']}\" as both use the \"{$ram['ram_type']}\" standard."
                    : "The RAM module \"{$ram['name']}\" uses \"{$ram['ram_type']}\", but motherboard \"{$mb['name']}\" only supports \"{$mb['ram_type']}\" RAM.",
];
            }
        }
        return $results;
    }

    /**
     * Check if the PSU(s) can support the total power draw of other components.
     *
     * @param array $psus Array of PSU details.
     * @param array $components Array of components with a 'tdp' attribute.
     * @return array Compatibility blocks.
     */
    public function checkPsuPower(array $psus, array $cpus = [], array $gpus = []): array
    {
        $results = [];

        $maxCpu = collect($cpus)->sortByDesc('tdp')->first();
        $maxGpu = collect($gpus)->sortByDesc('tdp')->first();

        $cpuTdp = $maxCpu['tdp'] ?? 0;
        $gpuTdp = $maxGpu['tdp'] ?? 0;
        $totalTdp = $cpuTdp + $gpuTdp;

        foreach ($psus as $psu) {
            $compatible = $psu['power'] >= $totalTdp;
            $results[] = [
                'block' => 'PSU - Components',
                'psu' => $psu,
                'cpu' => $maxCpu,
                'gpu' => $maxGpu,
                'components_total_tdp' => $totalTdp,
                'compatible' => $compatible,
                'message' => $compatible
                    ? "The most power-hungry CPU \"{$maxCpu['name']}\" ({$cpuTdp}W) and GPU \"{$maxGpu['name']}\" ({$gpuTdp}W) can both be supported by the PSU \"{$psu['name']}\" ({$psu['power']}W). Total draw: {$totalTdp}W."
                    : "The PSU \"{$psu['name']}\" ({$psu['power']}W) cannot support the most power-hungry CPU \"{$maxCpu['name']}\" ({$cpuTdp}W) and GPU \"{$maxGpu['name']}\" ({$gpuTdp}W). Required: {$totalTdp}W.",
            ];
        }

        return $results;
    }

}
