<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\Provider;

it('belongs to a provider.', function () {
    // Arrange
    /** @var Provider $Provider */
    $Provider = Provider::factory()
        ->has(Product::factory())
        ->create();

    // Act & Assert
    expect($Provider->products()->first())->toBeInstanceOf(Product::class);
});
