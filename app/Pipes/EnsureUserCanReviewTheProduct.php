<?php

declare(strict_types=1);

namespace App\Pipes;

use App\DataTransferObjects\ReviewDTO;
use App\Exceptions\ReviewException;
use Closure;

class EnsureUserCanReviewTheProduct
{
    public function handle(ReviewDTO $storeReviewDTO, Closure $next) // @pest-ignore-type
    {
        if (isset($storeReviewDTO->product->set_to_publicly_reviewable)) {
            return $next($storeReviewDTO);
        }

        // TODO:: check whether the user has bought the product
        // throw ReviewException::userHasNotBoughtTheProduct();

        return $next($storeReviewDTO);
    }
}
