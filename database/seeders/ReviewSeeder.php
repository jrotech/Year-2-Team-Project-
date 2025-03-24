<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Review;
use App\Models\Customer;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::pluck('id')->toArray();

        if (empty($customers)) {
            $this->command->warn('No customers found. Skipping review seeding.');
            return;
        }

        Product::all()->each(function ($product) use ($customers) {
            // Pick 3 unique customer IDs for each product
            $reviewers = collect($customers)->random(min(3, count($customers)));

            foreach ($reviewers as $customerId) {
                Review::factory()->create([
                    'product_id' => $product->id,
                    'customer_id' => $customerId,
                ]);
            }
        });

        $this->command->info('Seeded ~3 reviews per product.');
    }
}
