<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\GPUProduct;
use App\Models\Image;

class GpuSeeder extends Seeder
{
    public function run()
    {
        // 1. Fetch or create the GPU category
        $gpuCategory = Category::firstOrCreate(
            ['name' => 'GPU'],  
            [
                'description' => 'Graphics Processing Units.',
                'delete' => 0,
                'image' => 'categories/gpu.jpg',
            ]
        );

        // 2. Load JSON file and decode it
        $jsonFilePath = database_path('seeders/data/gpudata_withspecs.json'); // Path to the JSON file
        $jsonData = File::get($jsonFilePath); // Read JSON file
        $gpus = json_decode($jsonData, true); // Decode JSON into PHP array

        // 3. Loop over each GPU item and insert into database
        foreach ($gpus as $gpuData) {
            if(!isset($gpuData['name']) || !isset($gpuData['price']) || !isset($gpuData['description']) || !isset($gpuData['image_links'])) {
                continue;
            }
            // (a) main Product
            $product = Product::create([
                'name'          => $gpuData['name'],
                'price'         => $gpuData['price'],
                'description'   => $gpuData['description'],
                'specifications'=> $gpuData['specifications'] ?? null, // Ensure it's stored as JSON
                'in_stock'      => 1,
                'deleted'       => 0,
                'image'         => $gpuData['image_links'][0] ?? null, // Use first image as cover
            ]);

            // (b) stock record
            Stock::create([
                'product_id' => $product->id,
                'quantity'   => rand(10, 100), // Random stock quantity
            ]);

            // (c) attach category (many-to-many relation)
            $product->categories()->attach($gpuCategory->id);

            // (d) GPU-specific product details
            GpuProduct::create([
                'product_id' => $product->id,
                'tdp'        => $gpuData['tdp'] ?? 0, // Default to 0 if missing
            ]);

            // (e) multiple images
            foreach ($gpuData['image_links'] as $imageUrl) {
                Image::create([
                    'product_id' => $product->id,
                    'url'        => $imageUrl,
                    'alt'        => $gpuData['name'],
                ]);
            }
        }
    }
}
