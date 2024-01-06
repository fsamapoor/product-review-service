<?php

declare(strict_types=1);

namespace App\Pipes;

use App\DataTransferObjects\ReviewDTO;
use App\Exceptions\ReviewException;
use Closure;

class EnsureProductCanBeVotedOn
{
    /**
     * @throws ReviewException
     */
    public function handle(ReviewDTO $storeReviewDTO, Closure $next) // @pest-ignore-type
    {
        if (is_null($storeReviewDTO->vote)) {
            return $next($storeReviewDTO);
        }

        if (is_null($storeReviewDTO->product->set_to_votable_at)) {
            throw ReviewException::unvotableProduct();
        }

        return $next($storeReviewDTO);
    }
}
