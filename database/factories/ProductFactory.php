<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
            'provider_id' => Provider::factory(),
            'name' => fake()->name,
            'description' => fake()->paragraph,
            'set_to_commentable_at' => fake()->optional()->date,
            'set_to_votable_at' => fake()->optional()->date,
            'set_to_publicly_reviewable' => fake()->optional()->date,
            'published_at' => fake()->optional()->date,
        ];
    }

    public function published(?Carbon $published_at = null): self
    {
        return $this->state(
            fn (array $attributes) => ['published_at' => $published_at ?? now()]
        );
    }

    public function draft(): self
    {
        return $this->state(
            fn (array $attributes) => ['published_at' => null]
        );
    }
}
