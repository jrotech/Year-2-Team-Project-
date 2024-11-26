<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $products = [
            [
                'name' => 'Processor',
                'price' => 299.99,
                'description' => 'AMD Ryzen 7 5800X 8-core, 16-thread processor.',
                'in_stock' => true,
                'deleted' => null,
                'stock' => 50,
            ],
            [
                'name' => 'Graphics Card',
                'price' => 599.99,
                'description' => 'NVIDIA GeForce RTX 3070 with 8GB GDDR6 memory.',
                'in_stock' => true,
                'deleted' => null,
                'stock' => 30,
            ],
            [
                'name' => 'Motherboard',
                'price' => 199.99,
                'description' => 'ASUS ROG Strix B550-F Gaming motherboard with PCIe 4.0 support.',
                'in_stock' => true,
                'deleted' => null,
                'stock' => 100,
            ],
            [
                'name' => 'RAM',
                'price' => 79.99,
                'description' => 'Corsair Vengeance LPX 16GB (2 x 8GB) DDR4 3200MHz memory kit.',
                'in_stock' => true,
                'deleted' => null,
                'stock' => 200,
            ],
            [
                'name' => 'SSD',
                'price' => 109.99,
                'description' => 'Samsung 970 EVO Plus 1TB NVMe M.2 SSD.',
                'in_stock' => true,
                'deleted' => null,
                'stock' => 150,
            ],
            [
                'name' => 'Power Supply',
                'price' => 89.99,
                'description' => 'EVGA 600 W1, 80+ WHITE 600W power supply.',
                'in_stock' => true,
                'deleted' => null,
                'stock' => 75,
            ],
            [
                'name' => 'Case',
                'price' => 59.99,
                'description' => 'NZXT H510 Compact ATX Mid-Tower case.',
                'in_stock' => true,
                'deleted' => null,
                'stock' => 120,
            ],
            [
                'name' => 'Cooling Fan',
                'price' => 29.99,
                'description' => 'Cooler Master Hyper 212 Black Edition CPU air cooler.',
                'in_stock' => true,
                'deleted' => null,
                'stock' => 300,
            ],
            [
                'name' => 'Monitor',
                'price' => 249.99,
                'description' => 'Dell 27-inch Full HD monitor with IPS technology.',
                'in_stock' => true,
                'deleted' => null,
                'stock' => 60,
            ],
            [
                'name' => 'Keyboard',
                'price' => 49.99,
                'description' => 'Mechanical keyboard with RGB backlighting and Cherry MX switches.',
                'in_stock' => true,
                'deleted' => null,
                'stock' => 90,
            ],
        ];


        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
