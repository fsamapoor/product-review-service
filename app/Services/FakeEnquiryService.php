<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\EnquiryServiceContract;
use Illuminate\Support\Collection;

class FakeEnquiryService implements EnquiryServiceContract
{
    public function getProductPrices(Collection $productIds): Collection
    {
        return $productIds
            ->mapWithKeys(fn (int $productId): array => [
                $productId => random_int(10_000, 10_000_000),
            ]);
    }
}
