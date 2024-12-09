<?php
/********************************
Developer: Robert Oros
University ID: 230237144
********************************/
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Image;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create categories
        $categories = [
            ['name' => 'GPU', 'description' => 'Graphics Processing Units.', 'delete' => 0, 'image' => 'categories/gpu.jpg'],
            ['name' => 'CPU', 'description' => 'Central Processing Units.', 'delete' => 0, 'image' => 'categories/cpu.jpg'],
            ['name' => 'RAM', 'description' => 'Memory modules.', 'delete' => 0, 'image' => 'categories/ram.jpg'],
            ['name' => 'Motherboard', 'description' => 'Mainboards.', 'delete' => 0, 'image' => 'categories/motherboard.jpg'],
            ['name' => 'Storage', 'description' => 'SSDs and HDDs.', 'delete' => 0, 'image' => 'categories/ssd.jpg'],
            ['name' => 'Cooling', 'description' => 'Cooling solutions.', 'delete' => 0, 'image' => 'categories/cooling.jpg'],
        ];
        

        $categoryInstances = [];
        foreach ($categories as $category) {
            $categoryInstances[$category['name']] = Category::create([
                'name' => $category['name'],
                'description' => $category['description'],
                'delete' => $category['delete'],
                'image' => $category['image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        

        // Define products for each category
        $products = [
            'GPU' => [
                ['name' => 'NVIDIA RTX 4090', 'price' => 1599.99, 'description' => 'High-performance GPU for gaming.', 'image' => 'products/rtx_4090.jpg'],
                ['name' => 'AMD RX 7900', 'price' => 999.99, 'description' => 'Powerful GPU for creators.', 'image' => 'products/rx_7900.jpg'],
                ['name' => 'NVIDIA RTX 3070', 'price' => 699.99, 'description' => 'Affordable GPU for gamers.', 'image' => 'products/rtx_3070.jpg'],
                ['name' => 'AMD RX 6600', 'price' => 499.99, 'description' => 'Efficient GPU for budget builds.', 'image' => 'products/rx_6600.jpg'],
                ['name' => 'NVIDIA GTX 1650', 'price' => 229.99, 'description' => 'Entry-level GPU for casual users.', 'image' => 'products/gtx_1650.jpg'],
            ],
            'CPU' => [
                ['name' => 'Intel Core i9', 'price' => 599.99, 'description' => 'Top-tier performance processor.', 'image' => 'products/core_i9.jpg'],
                ['name' => 'AMD Ryzen 9', 'price' => 549.99, 'description' => 'High-end multitasking CPU.', 'image' => 'products/ryzen_9.jpg'],
                ['name' => 'Intel Core i7', 'price' => 419.99, 'description' => 'Reliable processor for gaming.', 'image' => 'products/core_i7.jpg'],
                ['name' => 'AMD Ryzen 5', 'price' => 299.99, 'description' => 'Budget-friendly performance CPU.', 'image' => 'products/ryzen_5.jpg'],
                ['name' => 'Intel Core i3', 'price' => 199.99, 'description' => 'Entry-level processor.', 'image' => 'products/core_i3.jpg'],
            ],
            'RAM' => [
                ['name' => 'Corsair Vengeance', 'price' => 159.99, 'description' => 'High-speed DDR5 RAM.', 'image' => 'products/corsair_vengeance.jpg'],
                ['name' => 'G.Skill Trident Z5', 'price' => 199.99, 'description' => 'Premium performance RAM.', 'image' => 'products/trident_z5.jpg'],
                ['name' => 'Kingston Fury', 'price' => 129.99, 'description' => 'Reliable memory module.', 'image' => 'products/kingston_fury.jpg'],
                ['name' => 'Crucial Ballistix', 'price' => 89.99, 'description' => 'Affordable memory solution.', 'image' => 'products/crucial_ballistix.jpg'],
                ['name' => 'TeamGroup T-Force', 'price' => 109.99, 'description' => 'RGB-enabled memory for style.', 'image' => 'products/teamgroup_tforce.jpg'],
            ],
            'Motherboard' => [
                ['name' => 'ASUS ROG Z790', 'price' => 499.99, 'description' => 'Premium gaming motherboard.', 'image' => 'products/asus_rog_z790.jpg'],
                ['name' => 'MSI MPG B650', 'price' => 349.99, 'description' => 'High-performance motherboard.', 'image' => 'products/msi_mpg_b650.jpg'],
                ['name' => 'Gigabyte Aorus Z790', 'price' => 449.99, 'description' => 'Feature-rich motherboard.', 'image' => 'products/aorus_z790.jpg'],
                ['name' => 'ASRock X670E', 'price' => 329.99, 'description' => 'Stable and reliable motherboard.', 'image' => 'products/asrock_x670e.jpg'],
                ['name' => 'MSI MAG B660', 'price' => 199.99, 'description' => 'Affordable motherboard option.', 'image' => 'products/msi_mag_b660.jpg'],
            ],
            'Storage' => [
                ['name' => 'Samsung 980 Pro', 'price' => 199.99, 'description' => 'Fast NVMe SSD for gaming.', 'image' => 'products/samsung_980_pro.jpg'],
                ['name' => 'WD Black SN850X', 'price' => 179.99, 'description' => 'Reliable high-speed SSD.', 'image' => 'products/wd_black_sn850x.jpg'],
                ['name' => 'Crucial P5 Plus', 'price' => 149.99, 'description' => 'Affordable NVMe SSD option.', 'image' => 'products/crucial_p5_plus.jpg'],
                ['name' => 'Seagate FireCuda', 'price' => 219.99, 'description' => 'Large-capacity SSD.', 'image' => 'products/seagate_firecuda.jpg'],
                ['name' => 'Kingston KC3000', 'price' => 189.99, 'description' => 'Great balance of speed and price.', 'image' => 'products/kingston_kc3000.jpg'],
            ],
            'Cooling' => [
                ['name' => 'Noctua NH-D15', 'price' => 99.99, 'description' => 'Quiet and powerful air cooler.', 'image' => 'products/noctua_nh_d15.jpg'],
                ['name' => 'Corsair H150i', 'price' => 159.99, 'description' => 'High-performance AIO cooler.', 'image' => 'products/corsair_h150i.jpg'],
                ['name' => 'NZXT Kraken X73', 'price' => 179.99, 'description' => 'Stylish liquid cooling solution.', 'image' => 'products/nzxt_kraken_x73.jpg'],
                ['name' => 'Arctic Freezer 34', 'price' => 49.99, 'description' => 'Affordable air cooling.', 'image' => 'products/arctic_freezer_34.jpg'],
                ['name' => 'Cooler Master Hyper 212', 'price' => 39.99, 'description' => 'Popular budget air cooler.', 'image' => 'products/cooler_master_hyper_212.jpg'],
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
                    'image' => $product['image'], // Add image field
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

                // Add an image for the product
                Image::create([
                    'product_id' => $createdProduct->id,
                    'url' => $product['image'], // Use the image URL from the product array
                    'alt' => $product['name'], // Use the product name as alt text
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
