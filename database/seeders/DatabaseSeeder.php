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
use App\Models\Image;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(CpuSeeder::class);
        $this->call(GpuSeeder::class);
        $this->call(MotherboardSeeder::class);
        $this->call(RamSeeder::class);
        $this->call(PsuSeeder::class);
        $this->call(StorageSeeder::class);
        $this->call(CoolingSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(InvoiceSeeder::class);

        
    }
}
