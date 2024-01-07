<?php

declare(strict_types=1);

namespace App\Actions;

use App\DataTransferObjects\ReviewDTO;
use App\Events\ReviewSubmitted;
use App\Models\Review;
use App\Pipes\EnsureProductCanBeCommentedOn;
use App\Pipes\EnsureProductCanBeVotedOn;
use App\Pipes\EnsureProductIsPublished;
use App\Pipes\EnsureUserCanReviewTheProduct;
use Illuminate\Support\Facades\Pipeline;

class StoreReviewAction
{
    public function handle(ReviewDTO $reviewDTO): void
    {
        Pipeline::send($reviewDTO)
            ->through([
                EnsureUserCanReviewTheProduct::class,
                EnsureProductIsPublished::class,
                EnsureProductCanBeCommentedOn::class,
                EnsureProductCanBeVotedOn::class,
            ])
            ->then(function (ReviewDTO $storeReviewDTO) {
                $review = Review::createFromDTO($storeReviewDTO);

                event(new ReviewSubmitted($review));
            });
    }
}
