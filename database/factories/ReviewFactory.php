<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ReviewRating;
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
            'comment' => fake()->optional()->paragraph,
            'vote' => fake()->optional()->randomElement(ReviewRating::values()),
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

    public function withVote(): self
    {
        return $this->state(
            fn (array $attributes) => [
                'vote' => fake()->randomElement(ReviewRating::values()),
            ]
        );
    }

    public function withoutVote(): self
    {
        return $this->state(
            fn (array $attributes) => [
                'vote' => null,
            ]
        );
    }

    public function withComment(): self
    {
        return $this->state(
            fn (array $attributes) => [
                'comment' => fake()->paragraph,
            ]
        );
    }

    public function withoutComment(): self
    {
        return $this->state(
            fn (array $attributes) => [
                'comment' => null,
            ]
        );
    }
}
