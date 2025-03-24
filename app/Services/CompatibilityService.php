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
            // Count the storage devices by connector type.
            $sataCount = 0;
            $m2Count = 0;

            foreach ($storages as $storage) {
                if (! isset($storage['connector_type'])) {
                    continue;
                }

                $type = strtolower($storage['connector_type']);

                if ($type === 'sata') {
                    $sataCount++;
                } elseif ($type === 'm.2') {
                    $m2Count++;
                }
            }

            // Build a description for the user's storage devices (omitting zeros).
            $deviceParts = [];
            if ($sataCount > 0) {
                $deviceParts[] = "{$sataCount} SATA";
            }
            if ($m2Count > 0) {
                $deviceParts[] = "{$m2Count} M.2";
            }
            // If both are zero, user has no storage devices for this motherboard
            $deviceDescription = !empty($deviceParts)
                ? implode(' and ', $deviceParts) . ' storage devices'
                : 'no storage devices';

            // Build a description for the motherboard’s available connectors (omitting zeros).
            $availableParts = [];
            if (!empty($mb['sata_storage_connectors'])) {
                $availableParts[] = "{$mb['sata_storage_connectors']} SATA";
            }
            if (!empty($mb['m2_storage_connectors'])) {
                $availableParts[] = "{$mb['m2_storage_connectors']} M.2";
            }
            $availableDescription = !empty($availableParts)
                ? implode(' and ', $availableParts) . ' connectors'
                : 'no connectors';

            // Check compatibility
            $compatible = ($sataCount <= $mb['sata_storage_connectors']) && ($m2Count <= $mb['m2_storage_connectors']);

            // Construct messages
            if ($compatible) {
                $message = "All storage devices in the basket can be connected to the motherboard \"{$mb['name']}\". "
                        . "You have {$deviceDescription}, which fit within the available {$availableDescription}.";
            } else {
                $message = "The motherboard \"{$mb['name']}\" lacks sufficient connectors. "
                        . "You have {$deviceDescription}, but only {$availableDescription} are available.";
            }

            $results[] = [
                'block' => 'Motherboard - Storage',
                'motherboard' => $mb,
                'storage' => $storages, // All storage devices are considered
                'compatible' => $compatible,
                'message' => $message,
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

        // Get the most power-hungry CPU.
        $maxCpu = collect($cpus)->sortByDesc('tdp')->first();
        // Get the most power-hungry GPU if available.
        $maxGpu = collect($gpus)->sortByDesc('tdp')->first();

        $cpuTdp = $maxCpu['tdp'] ?? 0;
        $gpuTdp = $maxGpu['tdp'] ?? 0;
        if ($gpuTdp === 0) {
            $gpuTdp = 260;
        }

        foreach ($psus as $psu) {
            // Check if a GPU is present.
            if ($maxGpu) {
                // Both CPU and GPU are present.
                $totalTdp = $cpuTdp + $gpuTdp;
                $requiredMinimum = round($totalTdp * 1.15);
                $requiredSafety  = round($totalTdp * 1.30);

                if ($psu['power'] < $requiredMinimum) {
                    $compatible = false;
                    $message = "The PSU \"{$psu['name']}\" ({$psu['power']}W) is insufficient for your CPU \"{$maxCpu['name']}\" ({$cpuTdp}W) and GPU \"{$maxGpu['name']}\" ({$gpuTdp}W). A minimum of {$requiredMinimum}W (15% margin) is required, and ideally {$requiredSafety}W (30% safety margin).";
                } elseif ($psu['power'] < $requiredSafety) {
                    $compatible = true;
                    $message = "The PSU \"{$psu['name']}\" ({$psu['power']}W) meets the minimum requirement (15% margin, {$requiredMinimum}W) for your CPU \"{$maxCpu['name']}\" ({$cpuTdp}W) and GPU \"{$maxGpu['name']}\" ({$gpuTdp}W), but falls short of the recommended 30% safety margin ({$requiredSafety}W).";
                } else {
                    $compatible = true;
                    $message = "The PSU \"{$psu['name']}\" ({$psu['power']}W) exceeds the recommended 30% safety margin ({$requiredSafety}W) for powering your CPU \"{$maxCpu['name']}\" ({$cpuTdp}W) and GPU \"{$maxGpu['name']}\" ({$gpuTdp}W).";
                }
            } else {
                // No GPU is present—only the CPU is considered.
                $totalTdp = $cpuTdp;
                $requiredMinimum = round($totalTdp * 1.15);
                $requiredSafety  = round($totalTdp * 1.30);

                if ($psu['power'] < $requiredMinimum) {
                    $compatible = false;
                    $message = "The PSU \"{$psu['name']}\" ({$psu['power']}W) is insufficient for your CPU \"{$maxCpu['name']}\" ({$cpuTdp}W). At least {$requiredMinimum}W is required.";
                } elseif ($psu['power'] < $requiredSafety) {
                    $compatible = true;
                    $extraWatts = $psu['power'] - $requiredMinimum;
                    $message = "The PSU \"{$psu['name']}\" ({$psu['power']}W) meets the minimum requirement (15% margin, {$requiredMinimum}W) for your CPU \"{$maxCpu['name']}\" ({$cpuTdp}W), leaving approximately {$extraWatts}W available for a future GPU and other components. Ideally, a PSU with {$requiredSafety}W (30% safety margin) is recommended.";
                } else {
                    $compatible = true;
                    $message = "The PSU \"{$psu['name']}\" ({$psu['power']}W) is well suited for your CPU \"{$maxCpu['name']}\" ({$cpuTdp}W), leaving ample headroom for a potential GPU and additional components.";
                }
            }

            $results[] = [
                'block' => 'PSU - Components',
                'psu' => $psu,
                'cpu' => $maxCpu,
                'gpu' => $maxGpu, // May be null if no GPU is present.
                'components_total_tdp' => $totalTdp,
                'required_minimum' => $requiredMinimum,
                'required_safety'  => $requiredSafety,
                'compatible' => $compatible,
                'message' => $message,
            ];
        }

        return $results;
    }


}
