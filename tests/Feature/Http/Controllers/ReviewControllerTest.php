<?php

declare(strict_types=1);

use App\Enums\ReviewRating;
use App\Events\ReviewSubmitted;
use App\Models\Product;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use TiMacDonald\Log\LogEntry;
use TiMacDonald\Log\LogFake;

use function Pest\Laravel\postJson;

beforeEach(function () {
    Event::fake();
    LogFake::bind();
});

it('can submit a review for commentable published products.', function () {
    // Arrange
    $product = Product::factory()
        ->published()
        ->commentable()
        ->create();

    // Act & Assert
    postJson(route('reviews.store'), [
        'product_id' => $product->id,
        'comment' => 'a review for the product.',
    ])
        ->assertCreated();

    Event::assertDispatched(ReviewSubmitted::class);
});

it('can submit a review for votable published products.', function () {
    // Arrange
    $product = Product::factory()
        ->published()
        ->votable()
        ->create();

    // Act & Assert
    postJson(route('reviews.store'), [
        'product_id' => $product->id,
        'vote' => array_rand(ReviewRating::values()),
    ])
        ->assertCreated();

    Event::assertDispatched(ReviewSubmitted::class);
});

it('cannot submit a review for unpublished products.', function () {
    // Arrange
    $product = Product::factory()
        ->draft()
        ->create();

    // Act & Assert
    postJson(route('reviews.store'), [
        'product_id' => $product->id,
        'comment' => 'a review for the product.',
    ])
        ->assertForbidden();

    Event::assertNotDispatched(ReviewSubmitted::class);
    Log::channel('review')
        ->assertLogged(
            fn (LogEntry $log) => $log->level === 'error'
            && $log->message === 'Unpublished products can not be reviewed!'
        );
});
