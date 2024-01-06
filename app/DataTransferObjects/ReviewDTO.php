<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Enums\ReviewStatus;
use App\Models\Product;
use App\Models\User;

readonly class ReviewDTO
{
    public function __construct(
        public ?string $comment,
        public ?int $vote,
        public Product $product,
        public ReviewStatus $reviewStatus,
        public User $user,
    ) {
    }
}
