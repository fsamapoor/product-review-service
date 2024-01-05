<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\Provider;
use App\Models\Review;

it('belongs to a provider.', function () {
    // Arrange
    /** @var Provider $Provider */
    $Provider = Provider::factory()
        ->has(Product::factory())
        ->create();

    // Act & Assert
    expect($Provider->products()->first())->toBeInstanceOf(Product::class);
});

it('has reviews.', function () {
    // Arrange
    $product = Product::factory()->create();

    $reviews = Review::factory()
        ->count(2)
        ->for($product)
        ->create();

    // Act & Assert
    expect($product->reviews)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Review::class);
});

it('only returns published products for published query scope.', function () {
    // Arrange
    Product::factory()->published()->create();
    Product::factory()->draft()->create();

    // Act && Assert
    expect(Product::query()->published()->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);
});
