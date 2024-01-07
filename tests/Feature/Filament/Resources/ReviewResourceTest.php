<?php

declare(strict_types=1);

use App\Filament\Resources\ReviewResource;
use App\Models\Review;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    login();
});

it('can render index page of the Product resource.', function () {
    // Act & Assert
    get(ReviewResource::getUrl())->assertOk();
});

it('can list reviews in the table.', function () {
    // Arrange
    $reviews = Review::factory()
        ->count(5)
        ->create();

    // Act & Assert
    livewire(ReviewResource\Pages\ListReviews::class)
        ->assertCanSeeTableRecords($reviews)
        ->assertTableActionExists('view')
        ->assertTableActionExists('edit')
        ->assertTableActionDoesNotExist('delete');
});

it('can not render create product page.', function () {
    // Act & Assert
    get(ReviewResource::getUrl('create'))
        ->assertNotFound();
})->throws(RouteNotFoundException::class);

it('can render edit product page.', function () {
    // Act & Assert
    get(ReviewResource::getUrl('edit', [
        'record' => Review::factory()->create(),
    ]))
        ->assertSuccessful();
});

it('can render view product page.', function () {
    // Act & Assert
    get(ReviewResource::getUrl('view', [
        'record' => Review::factory()->create(),
    ]))
        ->assertSuccessful();
});

it('can update review model.', function () {})->todo();
