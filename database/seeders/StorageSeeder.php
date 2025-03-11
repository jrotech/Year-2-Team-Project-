<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\StorageProduct;
use App\Models\Image;

class StorageSeeder extends Seeder
{
    public function run()
    {
        // 1. Fetch or create the Storage category
        $storageCategory = Category::firstOrCreate(
            ['name' => 'Storage'],  
            [
                'description' => 'Solid State Drives and Hard Disk Drives for storage solutions.',
                'delete' => 0,
                'image' => 'categories/storage.jpg',
            ]
        );

        // 2. Load JSON file and decode it
        $jsonFilePath = database_path('seeders/data/storagedata_withspecs.json'); // Path to the JSON file
        $jsonData = File::get($jsonFilePath); // Read JSON file
        $storages = json_decode($jsonData, true); // Decode JSON into PHP array

        // 3. Loop over each Storage item and insert into database
        foreach ($storages as $storageData) {
            if(!isset($storageData['name']) || !isset($storageData['price']) || !isset($storageData['description']) || !isset($storageData['image_links'])) {
                continue;
            }
            // (a) main Product
            $product = Product::create([
                'name'          => $storageData['name'],
                'price'         => $storageData['price'],
                'description'   => $storageData['description'],
                'specifications'=> $storageData['specifications'] ?? null, // Ensure it's stored as JSON
                'in_stock'      => 1,
                'deleted'       => 0,
                'image'         => $storageData['image_links'][0] ?? null, // Use first image as cover
            ]);

            // (b) stock record
            Stock::create([
                'product_id' => $product->id,
                'quantity'   => rand(10, 100), // Random stock quantity
            ]);

            // (c) attach category (many-to-many relation)
            $product->categories()->attach($storageCategory->id);

            // (d) Storage-specific product details
            StorageProduct::create([
                'product_id'      => $product->id,
                'connector_type'  => $storageData['connector_type'] ?? null,
            ]);

            // (e)multiple images
            foreach ($storageData['image_links'] as $imageUrl) {
                Image::create([
                    'product_id' => $product->id,
                    'url'        => $imageUrl,
                    'alt'        => $storageData['name'],
                ]);
            }
        }
    }
}
