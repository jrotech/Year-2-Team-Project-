<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CPUProduct;
use App\Models\GPUProduct;
use App\Models\MotherboardProduct;
use App\Models\RAMProduct;
use App\Models\SecondaryStorageProduct;
use App\Models\PSUProduct;
use App\Models\CoolerProduct;
use App\Models\Category;
use App\Services\CompatibilityService;
class CompatibilityController extends Controller
{
    protected $compatibilityService;

    //CompatibilityService dependency injection
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
            'secondary_storage' => [],
            'psu' => [],
            'cooling' => [],
        ];

        $productIds = $request->input('product_ids');

        // is a valid array
        if (!is_array($productIds) || empty($productIds)) {
            return response()->json(['error' => 'Invalid product IDs'], 400);
        }

        foreach ($productIds as $pid) {
            // Load the product with its categories and product-specific relationships
            $product = Product::with(['categories', 'cpu', 'gpu', 'motherboard', 'psu', 'ram', 'storage', 'cooler'])
                            ->findOrFail($pid);

            
            foreach ($product->categories as $category) { //damn categories being many to many
                switch (strtolower($category->name)) {
                    case 'cpu':
                        if ($product->cpu) {
                            $categorizedProducts['cpu'][] = [
                                'name' => $product->name,
                                'socket_type' => $product->cpu->socket_type,
                                'tdp' => $product->cpu->tdp,
                                'integrated_graphics' => $product->cpu->integrated_graphics,
                            ];
                        }
                        break;

                    case 'gpu':
                        if ($product->gpu) {
                            $categorizedProducts['gpu'][] = [
                                'name' => $product->name,
                                'tdp' => $product->gpu->tdp,
                            ];
                        }
                        break;

                    case 'motherboard':
                        if ($product->motherboard) {
                            $categorizedProducts['motherboard'][] = [
                                'name' => $product->name,
                                'ram_type' => $product->motherboard->ram_type,
                                'socket_type' => $product->motherboard->socket_type,
                                'sata_storage_connectors' => $product->motherboard->sata_storage_connectors,
                                'm2_storage_connectors' => $product->motherboard->m2_storage_connectors,
                            ];
                        }
                        break;

                    case 'ram':
                        if ($product->ram) {
                            $categorizedProducts['ram'][] = [
                                'name' => $product->name,
                                'ram_type' => $product->ram->ram_type,
                            ];
                        }
                        break;

                    case 'storage':
                        if ($product->storage) {
                            $categorizedProducts['storage'][] = [
                                'name' => $product->name,
                                'connector_type' => $product->storage->connector_type,
                               
                            ];
                        }
                        break;

                    case 'psu':
                        if ($product->psu) {
                            $categorizedProducts['psu'][] = [
                                'name' => $product->name,
                                'power' => $product->psu->power,
                            ];
                        }
                        break;

                    case 'cooling':
                        if ($product->cooler) {
                            
                            $categorizedProducts['cooling'][] = [
                                'name' => $product->name,
                                'supported_sockets' => $product->cooler->sockets->pluck('socket_type')->toArray(), 
                
                            ];
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

