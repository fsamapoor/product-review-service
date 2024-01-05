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

    public function status(ReviewStatus $reviewStatus): self
    {
        return $this->state(
            fn (array $attributes) => ['status' => $reviewStatus->value]
        );
    }

    public function approved(): self
    {
        return $this->status(ReviewStatus::APPROVED);
    }

    public function pending(): self
    {
        return $this->status(ReviewStatus::PENDING);
    }

    public function rejected(): self
    {
        return $this->status(ReviewStatus::REJECTED);
    }
}
