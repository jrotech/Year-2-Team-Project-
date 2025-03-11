<?php
/********************************
Developer: Robert Oros
University ID: 230237144
********************************/
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File; // Import File helper
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\CPUProduct;
use App\Models\Image;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        //$this->call(CPUSeeder::class);
        $this->call(GPUSeeder::class);
        
    }
}
