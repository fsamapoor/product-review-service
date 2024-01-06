<?php

declare(strict_types=1);

use App\Models\Product;

use function Pest\Laravel\getJson;

it('can load products.', function () {
    // Arrange
    Product::factory()
        ->published()
        ->count(10)
        ->create();

    // Act & Assert
    getJson(route('products.index'))
        ->assertSuccessful();
});

it('only loads published products.', function () {
    // Arrange
    Product::factory()->draft()->create();
    $published_product = Product::factory()->published()->create();

    // Act & Assert
    getJson(route('products.index'))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products.data');
});
