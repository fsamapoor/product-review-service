<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'description' => fake()->paragraph,
            'price' => fake()->paragraph,
            'set_to_commentable_at' => fake()->optional()->date,
            'set_to_votable_at' => fake()->optional()->date,
            'set_to_publicly_reviewable' => fake()->optional()->date,
            'published_at' => fake()->optional()->date,
        ];
    }
}
