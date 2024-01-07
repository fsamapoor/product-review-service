<?php

declare(strict_types=1);

namespace App\Pipes;

use App\DataTransferObjects\ReviewDTO;
use App\Exceptions\ReviewException;
use Closure;

class EnsureProductIsPublished
{
    /**
     * @throws ReviewException
     */
    public function handle(ReviewDTO $storeReviewDTO, Closure $next) // @pest-ignore-type
    {
        if (is_null($storeReviewDTO->product->published_at)) {
            throw ReviewException::unpublishedProduct();
        }

        return $next($storeReviewDTO);
    }
}
