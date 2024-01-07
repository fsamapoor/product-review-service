<?php

declare(strict_types=1);

use App\Models\Review;
use App\Models\User;

it('has reviews.', function () {
    // Arrange
    $user = User::factory()->create();

    $reviews = Review::factory()
        ->count(2)
        ->for($user)
        ->create();

    // Act & Assert
    expect($user->reviews)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Review::class);
});
