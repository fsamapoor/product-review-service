<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ReviewStatus;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'review' => fake()->optional()->paragraph,
            'rating' => fake()->optional()->randomElement([1, 2, 3, 4, 5]),
            'status' => fake()->randomElement(array_values(ReviewStatus::cases())),
        ];
    }
}
