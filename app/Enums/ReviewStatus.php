<?php

declare(strict_types=1);

namespace App\Enums;

enum ReviewStatus: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $reviewStatus) => [
                $reviewStatus->value => $reviewStatus->label(),
            ])
            ->toArray();
    }
}
