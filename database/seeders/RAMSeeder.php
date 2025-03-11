<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\RAMProduct;
use App\Models\Image;

class RamSeeder extends Seeder
{
    public function run()
    {
        // 1. Fetch or create the RAM category
        $ramCategory = Category::firstOrCreate(
            ['name' => 'RAM'],  
            [
                'description' => 'Memory modules for computers.',
                'delete' => 0,
                'image' => 'categories/ram.jpg',
            ]
        );

        // 2. Load JSON file and decode it
        $jsonFilePath = database_path('seeders/data/ramdata_withspecs.json'); // Path to the JSON file
        $jsonData = File::get($jsonFilePath); // Read JSON file
        $rams = json_decode($jsonData, true); // Decode JSON into PHP array

        // 3. Loop over each RAM item and insert into database
        foreach ($rams as $ramData) {
            if(!isset($ramData['name']) || !isset($ramData['price']) || !isset($ramData['description']) || !isset($ramData['image_links'])) {
                continue;
            }
            // (a) the main Product
            $product = Product::create([
                'name'          => $ramData['name'],
                'price'         => $ramData['price'],
                'description'   => $ramData['description'],
                'specifications'=> $ramData['specifications'] ?? null, // Ensure it's stored as JSON
                'in_stock'      => 1,
                'deleted'       => 0,
                'image'         => $ramData['image_links'][0] ?? null, // Use first image as cover
            ]);

            // (b) stock record
            Stock::create([
                'product_id' => $product->id,
                'quantity'   => rand(10, 100), // Random stock quantity
            ]);

            // (c) attach category (many-to-many relation)
            $product->categories()->attach($ramCategory->id);

            // (d) RAM-specific product details
            RamProduct::create([
                'product_id' => $product->id,
                'ram_type'   => $ramData['ram_type'] ?? null,
            ]);

            // (e)multiple images
            foreach ($ramData['image_links'] as $imageUrl) {
                Image::create([
                    'product_id' => $product->id,
                    'url'        => $imageUrl,
                    'alt'        => $ramData['name'],
                ]);
            }
        }
    }
}
