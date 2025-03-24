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
        // Cache the IDs once
        $customerIds = Customer::pluck('id')->toArray();
        $products = Product::all();

        if (empty($customerIds)) {
            $this->command->warn('No customers found. Skipping review seeding.');
            return;
        }

        foreach ($products as $product) {
            // Pick up to 3 unique customers per product
            $reviewers = collect($customerIds)->shuffle()->take(3);

            foreach ($reviewers as $customerId) {
                Review::create([
                    'product_id' => $product->id,
                    'customer_id' => $customerId,
                    'rating' => rand(3, 5),
                    'comment' => fake()->randomElement([
                       'Great performance for the price.',
                        'Runs quiet and cool even under heavy load.',
                        'Solid build quality, feels premium.',
                        'Installation was straightforward, no issues.',
                        'Good for mid-tier gaming setups.',
                        'Not the best thermals, but does the job.',
                        'Handles multitasking well.',
                        'Exceeded my expectations.',
                        'Slight coil whine but nothing major.',
                        'Perfect match for my build aesthetic.',
                        'Great value compared to similar options.',
                        'Boot times are super fast now.',
                        'Fits perfectly in my micro ATX case.',
                        'VR ready and handles it smoothly.',
                        'Great upgrade from my previous setup.',
                        'Would buy again, no regrets.',
                        'Works well out of the box, no tweaking needed.',
                        'Gaming at 1080p is buttery smooth.',
                        'Temps stay under control even while rendering.',
                        'Customer support was helpful during setup.',
                    ])
                ]);
            }
        }

        $this->command->info('Seeded ~3 reviews per product.');
    }
}
