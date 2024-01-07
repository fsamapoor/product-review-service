<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\Provider;

it('has products.', function () {
    // Arrange
    /** @var Provider $Provider */
    $Provider = Provider::factory()
        ->has(Product::factory()->count(2))
        ->create();

    // Act & Assert
    expect($Provider->products)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Product::class);
});
