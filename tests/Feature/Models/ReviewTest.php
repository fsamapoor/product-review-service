<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\Review;
use App\Models\User;

it('belongs to a product.', function () {
    // Arrange
    $product = Product::factory()->create();

    $review = Review::factory()
        ->for($product)
        ->create();

    // Act & Assert
    expect($product->reviews()->first())->toBeInstanceOf(Review::class);
});

it('belongs to a user.', function () {
    // Arrange
    $user = User::factory()->create();

    $review = Review::factory()
        ->for($user)
        ->create();

    // Act & Assert
    expect($user->reviews()->first())->toBeInstanceOf(Review::class);
});

it('only returns approved reviews for approved query scope.', function () {
    // Arrange
    Review::factory()->approved()->create();
    Review::factory()->pending()->create();

    // Act && Assert
    expect(Review::query()->approved()->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);
});
