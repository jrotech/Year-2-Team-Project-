<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\CPUProduct;
use App\Models\Image;

class CpuSeeder extends Seeder
{
    public function run()
    {
        // 1. Fetch or create the CPU category
        
        $cpuCategory = Category::firstOrCreate(
            ['name' => 'CPU'],  
            [
                'description' => 'Central Processing Units',
                'delete' => 0,
                'image' => 'categories/cpu.jpg',
            ]
        );
        
       // 2. JSON Array of CPU data
        $jsonFilePath = database_path('seeders/data/cpudata_withspecs.json'); // Define path
        $jsonData = File::get($jsonFilePath); // Read the file
        $cpus = json_decode($jsonData, true); // Convert JSON to PHP array

        // 3. Loop over each CPU item
        foreach ($cpus as $cpuData) {
            if(!isset($cpuData['name']) || !isset($cpuData['price']) || !isset($cpuData['description']) || !isset($cpuData['image_links'])) {
                continue;
            }
            // (a) main Product
            $product = Product::create([
                'name'          => $cpuData['name'],
                'price'         => $cpuData['price'],
                'description'   => $cpuData['description'],
                'specifications'=> $cpuData['specifications'],
                'in_stock'      => 1,
                'deleted'       => 0,
                'image'         => $cpuData['image_links'][0] ?? null,
            ]);

            // (b) Stock record
            Stock::create([
                'product_id' => $product->id,
                'quantity'   => 100,  // or random, e.g. rand(10,100)
            ]);

            // (c) attach category (the many-to-many pivot)
            $product->categories()->attach($cpuCategory->id);

            // (d) CPU-specific product details
            CpuProduct::create([
                'product_id'          => $product->id,
                'socket_type'         => $cpuData['socket_type'],
                'tdp'                 => $cpuData['tdp'],
                'integrated_graphics' => $cpuData['integrated_graphics'],
            ]);

            // (e) multiple images 
            foreach ($cpuData['image_links'] as $link) {
                Image::create([
                    'product_id' => $product->id,
                    'url'        => $link,
                    'alt'        => $cpuData['name'],
                ]);
            }
        }
    }
}
