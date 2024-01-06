<?php

declare(strict_types=1);

namespace App\Pipes;

use App\DataTransferObjects\ReviewDTO;
use App\Exceptions\ReviewException;
use Closure;

class EnsureProductCanBeCommentedOn
{
    /**
     * @throws ReviewException
     */
    public function handle(ReviewDTO $storeReviewDTO, Closure $next)
    {
        if (is_null($storeReviewDTO->comment)) {
            return $next($storeReviewDTO);
        }

        if (is_null($storeReviewDTO->product->set_to_commentable_at)) {
            throw ReviewException::uncommentableProduct();
        }

        return $next($storeReviewDTO);
    }
}
