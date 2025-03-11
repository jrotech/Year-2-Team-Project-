<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\CoolerProduct;
use App\Models\CoolerSocket;
use App\Models\Image;

class CoolingSeeder extends Seeder
{
    public function run()
    {
        // 1. Fetch or create the Cooling category
        $coolerCategory = Category::firstOrCreate(
            ['name' => 'Cooling'],  
            [
                'description' => 'Cooling solutions for CPUs and GPUs.',
                'delete' => 0,
                'image' => 'categories/cooling.jpg',
            ]
        );

        // 2. Load JSON file and decode it
        $jsonFilePath = database_path('seeders/data/coolingdata_withspecs.json'); // Path to the JSON file
        $jsonData = File::get($jsonFilePath); // Read JSON file
        $coolers = json_decode($jsonData, true); // Decode JSON into PHP array

        // 3. Loop over each cooler item and insert into database
        foreach ($coolers as $coolerData) {
            if(!isset($coolerData['name']) || !isset($coolerData['price']) || !isset($coolerData['description']) || !isset($coolerData['image_links'])) {
                continue;
            }
            // (a) main Product
            $product = Product::create([
                'name'          => $coolerData['name'],
                'price'         => $coolerData['price'],
                'description'   => $coolerData['description'],
                'specifications'=> $coolerData['specifications'] ?? null, // Ensure it's stored as JSON
                'in_stock'      => 1,
                'deleted'       => 0,
                'image'         => $coolerData['image_links'][0] ?? null, // Use first image as cover
            ]);

            // (b) stock record
            Stock::create([
                'product_id' => $product->id,
                'quantity'   => rand(10, 100), // Random stock quantity
            ]);

            // (c) attach category (many-to-many relation)
            $product->categories()->attach($coolerCategory->id);

            // (d) Cooler-specific product details
            $coolerProduct = CoolerProduct::create([
                'product_id' => $product->id,
            ]);

            // (e) supported sockets in cooler_sockets table
            if (!empty($coolerData['compatible_sockets'])) {
                foreach ($coolerData['compatible_sockets'] as $socketType) {
                    CoolerSocket::create([
                        'cooler_id'   => $coolerProduct->id,
                        'socket_type' => $socketType,
                    ]);
                }
            }

            // (f) multiple images
            foreach ($coolerData['image_links'] as $imageUrl) {
                Image::create([
                    'product_id' => $product->id,
                    'url'        => $imageUrl,
                    'alt'        => $coolerData['name'],
                ]);
            }
        }
    }
}
