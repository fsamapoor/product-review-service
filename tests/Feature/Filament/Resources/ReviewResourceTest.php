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

it('can render index page of the Review resource.', function () {
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
        ->assertTableActionDoesNotExist('edit')
        ->assertTableActionDoesNotExist('delete');
});

it('can not render create review page.', function () {
    // Act & Assert
    get(ReviewResource::getUrl('create'))
        ->assertNotFound();
})->throws(RouteNotFoundException::class);

it('can update review model.', function () {
})->todo();
