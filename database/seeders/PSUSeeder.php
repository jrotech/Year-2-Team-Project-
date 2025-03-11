<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\PSUProduct;
use App\Models\Image;

class PsuSeeder extends Seeder
{
    public function run()
    {
        // 1. Fetch or create the PSU category
        $psuCategory = Category::firstOrCreate(
            ['name' => 'PSU'],  
            [
                'description' => 'Power Supply Units for computers.',
                'delete' => 0,
                'image' => 'categories/psu.jpg',
            ]
        );

        // 2. Load JSON file and decode it
        $jsonFilePath = database_path('seeders/data/psudata_withspecs.json'); // Path to the JSON file
        $jsonData = File::get($jsonFilePath); // Read JSON file
        $psus = json_decode($jsonData, true); // Decode JSON into PHP array

        // 3. Loop over each PSU item and insert into database
        foreach ($psus as $psuData) {
            if (!isset($psuData['name']) || !isset($psuData['price']) || !isset($psuData['description']) || !isset($psuData['image_links'])) {
                continue;
            }
            // (a) main Product
            $product = Product::create([
                'name'          => $psuData['name'],
                'price'         => $psuData['price'],
                'description'   => $psuData['description'],
                'specifications'=> $psuData['specifications'] ?? null, 
                'in_stock'      => 1,
                'deleted'       => 0,
                'image'         => $psuData['image_links'][0] ?? null, 
            ]);

            // (b) stock record
            Stock::create([
                'product_id' => $product->id,
                'quantity'   => rand(10, 100), 
            ]);

            // (c) attach category (many-to-many relation)
            $product->categories()->attach($psuCategory->id);

            // (d) PSU-specific product details
            PsuProduct::create([
                'product_id' => $product->id,
                'power'      => $psuData['power'] ?? 0, // Default to 0 if missing
            ]);

            // (e) multiple images referencing this product
            foreach ($psuData['image_links'] as $imageUrl) {
                Image::create([
                    'product_id' => $product->id,
                    'url'        => $imageUrl,
                    'alt'        => $psuData['name'],
                ]);
            }
        }
    }
}
