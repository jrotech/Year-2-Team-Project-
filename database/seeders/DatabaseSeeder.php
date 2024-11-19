<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create categories
        $category1 = Category::create([
            'name' => 'Cooling Solutions',
            'image' => 'cooling.jpg'
        ]);
    
        $category2 = Category::create([
            'name' => 'Power Supplies',
            'image' => 'power.jpg'
        ]);
    
        // Create products
        Product::create([
            'name' => 'Water Cooler X1',
            'price' => 149.99,
            'image' => 'water_cooler_x1.jpg',
            'is_best_seller' => true,
            'category_id' => $category1->id
        ]);
    
        Product::create([
            'name' => 'Power Supply YZ',
            'price' => 99.99,
            'image' => 'power_supply_yz.jpg',
            'is_best_seller' => false,
            'category_id' => $category2->id
        ]);
    }
}
