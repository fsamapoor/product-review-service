<?php

declare(strict_types=1);

namespace App\Enums;

enum ReviewRating: int
{
    case VERY_BAD = 1;
    case BAD = 2;
    case OK = 3;
    case GOOD = 4;
    case VERY_GOOD = 5;

    public static function values(): array
    {
        return collect(self::cases())
            ->pluck('value')
            ->toArray();
    }
}
