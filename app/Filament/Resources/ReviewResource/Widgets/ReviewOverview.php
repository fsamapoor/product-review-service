<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReviewResource\Widgets;

use App\Filament\Resources\ReviewResource\Pages\ListReviews;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReviewOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListReviews::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make(
                label : 'Total Reviews',
                value: $this->getPageTableQuery()
                    ->count(),
            ),
            Stat::make(
                label: 'Pending Reviews',
                value: $this->getPageTableQuery()
                    ->pending()
                    ->count(),
            ),
            Stat::make(
                label: 'Rejected Reviews',
                value: $this->getPageTableQuery()
                    ->rejected()
                    ->count(),
            ),
        ];
    }
}
