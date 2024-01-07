<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Support\Collection;

interface EnquiryServiceContract
{
    public function getProductPrices(Collection $productIds): Collection;
}
