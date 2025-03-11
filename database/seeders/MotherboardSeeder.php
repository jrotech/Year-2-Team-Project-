<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\MotherboardProduct;
use App\Models\Image;

class MotherboardSeeder extends Seeder
{
    public function run()
    {
        // 1. Fetch or create the Motherboard category
        $motherboardCategory = Category::firstOrCreate(
            ['name' => 'Motherboard'],  
            [
                'description' => 'Mainboards for computers.',
                'delete' => 0,
                'image' => 'categories/motherboard.jpg',
            ]
        );

        // 2. Load JSON file and decode it
        $jsonFilePath = database_path('seeders/data/motherboarddata_withspecs.json'); // Path to the JSON file
        $jsonData = File::get($jsonFilePath); // Read JSON file
        $motherboards = json_decode($jsonData, true); // Decode JSON into PHP array

        // 3. Loop over each Motherboard item and insert into database
        foreach ($motherboards as $motherboardData) {
            if(!isset($motherboardData['name']) || !isset($motherboardData['price']) || !isset($motherboardData['description']) || !isset($motherboardData['image_links'])) {
                continue;
            }
            // (a) main Product
            $product = Product::create([
                'name'          => $motherboardData['name'],
                'price'         => $motherboardData['price'],
                'description'   => $motherboardData['description'],
                'specifications'=> $motherboardData['specifications'] ?? null, // Ensure it's stored as JSON
                'in_stock'      => 1,
                'deleted'       => 0,
                'image'         => $motherboardData['image_links'][0] ?? null, // Use first image as cover
            ]);

            // (b) stock record
            Stock::create([
                'product_id' => $product->id,
                'quantity'   => rand(10, 100), // Random stock quantity
            ]);

            // (c) attach category (many-to-many relation)
            $product->categories()->attach($motherboardCategory->id);

            // (d) Motherboard-specific product details
            MotherboardProduct::create([
                'product_id'               => $product->id,
                'socket_type'              => $motherboardData['socket_type'] ?? null,
                'ram_type'                 => $motherboardData['ram_type'] ?? null,
                'sata_storage_connectors'  => $motherboardData['SATA_storage_connectors'] ?? 0,
                'm2_storage_connectors'    => $motherboardData['M2_storage_connectors'] ?? 0,
            ]);

            // (e) multiple images
            foreach ($motherboardData['image_links'] as $imageUrl) {
                Image::create([
                    'product_id' => $product->id,
                    'url'        => $imageUrl,
                    'alt'        => $motherboardData['name'],
                ]);
            }
        }
    }
}
