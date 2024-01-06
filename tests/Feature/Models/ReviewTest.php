<?php

declare(strict_types=1);

use App\DataTransferObjects\ReviewDTO;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

use function Pest\Laravel\assertDatabaseEmpty;
use function PHPUnit\Framework\assertTrue;

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

it('only returns reviews with comments for hasComment query scope.', function () {
    // Arrange
    Review::factory()->withComment()->withoutVote()->create();
    Review::factory()->withVote()->withoutComment()->create();

    // Act && Assert
    expect(Review::query()->hasComment()->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);
});

it('only returns reviews with votes for hasVote query scope.', function () {
    // Arrange
    Review::factory()->withVote()->withoutComment()->create();
    Review::factory()->withComment()->withoutVote()->create();

    // Act && Assert
    expect(Review::query()->hasVote()->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);
});

it('can create a review based on ReviewDTO.', function () {
    // Arrange
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $review = Review::factory()
        ->for($user)
        ->for($product)
        ->make();

    $reviewDTO = new ReviewDTO(
        comment: $review->comment,
        vote: $review->vote,
        product: $review->product,
        reviewStatus: $review->status,
        user: $user,
    );

    // Act & Assert
    assertDatabaseEmpty('reviews');

    $created_review = Review::createFromDTO($reviewDTO);

    expect(Review::all())->toHaveCount(1)
        ->and($created_review->comment)->toEqual($review->comment)
        ->and($created_review->vote)->toEqual($review->vote)
        ->and($created_review->status)->toEqual($review->status->value);

    assertTrue($user->is($created_review->user));
    assertTrue($product->is($created_review->product));
});
