<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CpuProduct;
use App\Models\GpuProduct;
use App\Models\MotherboardProduct;
use App\Models\RamProduct;
use App\Models\SecondaryStorageProduct;
use App\Models\PsuProduct;
use App\Models\CoolerProduct;
use App\Models\Category;
use App\Services\CompatibilityService;

class CompatibilityController extends Controller
{
    protected $compatibilityService;

    // Dependency injection of the CompatibilityService
    public function __construct(CompatibilityService $compatibilityService)
    {
        $this->compatibilityService = $compatibilityService;
    }

    public function checkCompatibility(Request $request)
    {
        $categorizedProducts = [
            'cpu' => [],
            'gpu' => [],
            'motherboard' => [],
            'ram' => [],
            'storage' => [], // using 'storage' for secondary storage
            'psu' => [],
            'cooling' => [],
        ];

        // Expecting payload in the form:
        // { "products": [ { "id": 1, "quantity": 2 }, { "id": 2, "quantity": 1 } ] }
        $productsData = $request->input('products');

        if (!is_array($productsData) || empty($productsData)) {
            return response()->json(['error' => 'Invalid product data'], 400);
        }

        foreach ($productsData as $data) {
            if (!isset($data['id'], $data['quantity'])) {
                continue; // or return an error if preferred
            }

            $pid = $data['id'];
            $quantity = (int) $data['quantity'];

            // Load the product with its related models
            $product = Product::with(['categories', 'cpu', 'gpu', 'motherboard', 'psu', 'ram', 'storage', 'cooler'])
                        ->findOrFail($pid);

            foreach ($product->categories as $category) {
                switch (strtolower($category->name)) {
                    case 'cpu':
                        // Only add once per product (ignoring quantity)
                        if (!array_filter($categorizedProducts['cpu'], fn($item) => $item['id'] === $product->id)) {
                            if ($product->cpu) {
                                $categorizedProducts['cpu'][] = [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'socket_type' => $product->cpu->socket_type,
                                    'tdp' => $product->cpu->tdp,
                                    'integrated_graphics' => $product->cpu->integrated_graphics,
                                ];
                            }
                        }
                        break;

                    case 'gpu':
                        if (!array_filter($categorizedProducts['gpu'], fn($item) => $item['id'] === $product->id)) {
                            if ($product->gpu) {
                                $categorizedProducts['gpu'][] = [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'tdp' => $product->gpu->tdp,
                                ];
                            }
                        }
                        break;

                    case 'motherboard':
                        if (!array_filter($categorizedProducts['motherboard'], fn($item) => $item['id'] === $product->id)) {
                            if ($product->motherboard) {
                                $categorizedProducts['motherboard'][] = [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'ram_type' => $product->motherboard->ram_type,
                                    'socket_type' => $product->motherboard->socket_type,
                                    'sata_storage_connectors' => $product->motherboard->sata_storage_connectors,
                                    'm2_storage_connectors' => $product->motherboard->m2_storage_connectors,
                                ];
                            }
                        }
                        break;

                    case 'ram':
                        if (!array_filter($categorizedProducts['ram'], fn($item) => $item['id'] === $product->id)) {
                            if ($product->ram) {
                                $categorizedProducts['ram'][] = [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'ram_type' => $product->ram->ram_type,
                                ];
                            }
                        }
                        break;

                    case 'storage':
                        // For storage, replicate the entry based on quantity
                        if ($product->storage) {
                            for ($i = 0; $i < $quantity; $i++) {
                                $categorizedProducts['storage'][] = [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'connector_type' => $product->storage->connector_type,
                                ];
                            }
                        }
                        break;

                    case 'psu':
                        if (!array_filter($categorizedProducts['psu'], fn($item) => $item['id'] === $product->id)) {
                            if ($product->psu) {
                                $categorizedProducts['psu'][] = [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'power' => $product->psu->power,
                                ];
                            }
                        }
                        break;

                    case 'cooling':
                        if (!array_filter($categorizedProducts['cooling'], fn($item) => $item['id'] === $product->id)) {
                            if ($product->cooler) {
                                $categorizedProducts['cooling'][] = [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'supported_sockets' => $product->cooler->sockets->pluck('socket_type')->toArray(),
                                ];
                            }
                        }
                        break;
                }
            }
        }

        $compatibilityBlocks = [];

        if (!empty($categorizedProducts['motherboard']) && !empty($categorizedProducts['cpu'])) {
            $compatibilityBlocks = array_merge(
                $compatibilityBlocks,
                $this->compatibilityService->checkMotherboardCpu($categorizedProducts['motherboard'], $categorizedProducts['cpu'])
            );
        }

        if (!empty($categorizedProducts['cpu']) && !empty($categorizedProducts['cooling'])) {
            $compatibilityBlocks = array_merge(
                $compatibilityBlocks,
                $this->compatibilityService->checkCpuCooler($categorizedProducts['cpu'], $categorizedProducts['cooling'])
            );
        }

        if (!empty($categorizedProducts['motherboard']) && !empty($categorizedProducts['storage'])) {
            $compatibilityBlocks = array_merge(
                $compatibilityBlocks,
                $this->compatibilityService->checkMotherboardStorage($categorizedProducts['motherboard'], $categorizedProducts['storage'])
            );
        }

        if (!empty($categorizedProducts['motherboard']) && !empty($categorizedProducts['gpu'])) {
            $compatibilityBlocks = array_merge(
                $compatibilityBlocks,
                $this->compatibilityService->checkMotherboardGpu($categorizedProducts['motherboard'], $categorizedProducts['gpu'])
            );
        }

        if (!empty($categorizedProducts['motherboard']) && !empty($categorizedProducts['ram'])) {
            $compatibilityBlocks = array_merge(
                $compatibilityBlocks,
                $this->compatibilityService->checkMotherboardRam($categorizedProducts['motherboard'], $categorizedProducts['ram'])
            );
        }

        if (!empty($categorizedProducts['psu'])) {
            $compatibilityBlocks = array_merge(
                $compatibilityBlocks,
                $this->compatibilityService->checkPsuPower(
                    $categorizedProducts['psu'],
                    $categorizedProducts['cpu'] ?? [],
                    $categorizedProducts['gpu'] ?? []
                )
            );
        }

        return response()->json([
            'compatibility_blocks' => $compatibilityBlocks,
        ]);
    }
}
