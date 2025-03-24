<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        $techComments = [
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
            'Customer support was helpful during setup.'
        ];

        return [
            'product_id' => Product::inRandomOrder()->first()?->id ?? 1,
            'customer_id' => Customer::inRandomOrder()->first()?->id ?? 1,
            'rating' => $this->faker->biasedNumberBetween(3, 5, fn($x) => 1 - abs(4 - $x) / 2),
            'comment' => $this->faker->randomElement($techComments),
        ];
    }
}
