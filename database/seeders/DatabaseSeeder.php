<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create categories
        $categories = [
            'GPU' => 'Graphics Processing Units for gaming and computation.',
            'CPU' => 'Central Processing Units for performance and multitasking.',
            'RAM' => 'Memory modules for faster performance.',
            'Motherboard' => 'Mainboards to connect your components.',
            'Storage' => 'High-speed SSDs and large HDDs.',
            'Cooling' => 'Cooling solutions for thermal management.',
        ];

        $categoryInstances = [];
        foreach ($categories as $name => $description) {
            $categoryInstances[$name] = Category::create([
                'name' => $name,
                'description' => $description,
                'delete' => 0, // Active category
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Define products for each category
        $products = [
            'GPU' => [
                ['name' => 'NVIDIA RTX 4090', 'price' => 1599.99, 'description' => 'High-performance GPU for gaming.'],
                ['name' => 'AMD RX 7900', 'price' => 999.99, 'description' => 'Powerful GPU for creators.'],
                ['name' => 'NVIDIA RTX 3070', 'price' => 699.99, 'description' => 'Affordable GPU for gamers.'],
                ['name' => 'AMD RX 6600', 'price' => 499.99, 'description' => 'Efficient GPU for budget builds.'],
                ['name' => 'NVIDIA GTX 1650', 'price' => 229.99, 'description' => 'Entry-level GPU for casual users.'],
            ],
            'CPU' => [
                ['name' => 'Intel Core i9', 'price' => 599.99, 'description' => 'Top-tier performance processor.'],
                ['name' => 'AMD Ryzen 9', 'price' => 549.99, 'description' => 'High-end multitasking CPU.'],
                ['name' => 'Intel Core i7', 'price' => 419.99, 'description' => 'Reliable processor for gaming.'],
                ['name' => 'AMD Ryzen 5', 'price' => 299.99, 'description' => 'Budget-friendly performance CPU.'],
                ['name' => 'Intel Core i3', 'price' => 199.99, 'description' => 'Entry-level processor.'],
            ],
            'RAM' => [
                ['name' => 'Corsair Vengeance', 'price' => 159.99, 'description' => 'High-speed DDR5 RAM.'],
                ['name' => 'G.Skill Trident Z5', 'price' => 199.99, 'description' => 'Premium performance RAM.'],
                ['name' => 'Kingston Fury', 'price' => 129.99, 'description' => 'Reliable memory module.'],
                ['name' => 'Crucial Ballistix', 'price' => 89.99, 'description' => 'Affordable memory solution.'],
                ['name' => 'TeamGroup T-Force', 'price' => 109.99, 'description' => 'RGB-enabled memory for style.'],
            ],
            'Motherboard' => [
                ['name' => 'ASUS ROG Z790', 'price' => 499.99, 'description' => 'Premium gaming motherboard.'],
                ['name' => 'MSI MPG B650', 'price' => 349.99, 'description' => 'High-performance motherboard.'],
                ['name' => 'Gigabyte Aorus Z790', 'price' => 449.99, 'description' => 'Feature-rich motherboard.'],
                ['name' => 'ASRock X670E', 'price' => 329.99, 'description' => 'Stable and reliable motherboard.'],
                ['name' => 'MSI MAG B660', 'price' => 199.99, 'description' => 'Affordable motherboard option.'],
            ],
            'Storage' => [
                ['name' => 'Samsung 980 Pro', 'price' => 199.99, 'description' => 'Fast NVMe SSD for gaming.'],
                ['name' => 'WD Black SN850X', 'price' => 179.99, 'description' => 'Reliable high-speed SSD.'],
                ['name' => 'Crucial P5 Plus', 'price' => 149.99, 'description' => 'Affordable NVMe SSD option.'],
                ['name' => 'Seagate FireCuda', 'price' => 219.99, 'description' => 'Large-capacity SSD.'],
                ['name' => 'Kingston KC3000', 'price' => 189.99, 'description' => 'Great balance of speed and price.'],
            ],
            'Cooling' => [
                ['name' => 'Noctua NH-D15', 'price' => 99.99, 'description' => 'Quiet and powerful air cooler.'],
                ['name' => 'Corsair H150i', 'price' => 159.99, 'description' => 'High-performance AIO cooler.'],
                ['name' => 'NZXT Kraken X73', 'price' => 179.99, 'description' => 'Stylish liquid cooling solution.'],
                ['name' => 'Arctic Freezer 34', 'price' => 49.99, 'description' => 'Affordable air cooling.'],
                ['name' => 'Cooler Master Hyper 212', 'price' => 39.99, 'description' => 'Popular budget air cooler.'],
            ],
        ];

        foreach ($products as $categoryName => $productList) {
            foreach ($productList as $product) {
                $createdProduct = Product::create([
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'description' => $product['description'],
                    'in_stock' => rand(0, 1), // Randomly mark as in stock or not
                    'deleted' => 0, // Active product
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        
                // Add stock for each product
                Stock::create([
                    'product_id' => $createdProduct->id,
                    'quantity' => $createdProduct->in_stock ? rand(10, 100) : 0, // Random stock if in stock
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        
                // Add the product-category relationship (populate the product_categories table)
                $createdProduct->categories()->attach($categoryInstances[$categoryName]->id);
            }
        }
    }
}
