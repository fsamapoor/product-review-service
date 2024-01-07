<?php

declare(strict_types=1);

use App\Filament\Resources\ProductResource;
use App\Models\Product;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    login();
});

it('can render index page of the Product resource.', function () {
    // Act & Assert
    get(ProductResource::getUrl())->assertOk();
});

it('can list products in the table.', function () {
    // Arrange
    $products = Product::factory()
        ->count(5)
        ->create();

    // Act & Assert
    livewire(ProductResource\Pages\ListProducts::class)
        ->assertCanSeeTableRecords($products)
        ->assertTableActionExists('view')
        ->assertTableActionExists('edit')
        ->assertTableActionDoesNotExist('delete');
});

it('can render create product page.', function () {
    // Act & Assert
    get(ProductResource::getUrl('create'))
        ->assertOk();
});

it('can render edit product page.', function () {
    // Act & Assert
    get(ProductResource::getUrl('edit', [
        'record' => Product::factory()->create(),
    ]))
        ->assertSuccessful();
});

it('can render view product page.', function () {
    // Act & Assert
    get(ProductResource::getUrl('view', [
        'record' => Product::factory()->create(),
    ]))
        ->assertSuccessful();
});

it('can create a new product.', function () {})->todo();

it('can update product model.', function () {})->todo();
