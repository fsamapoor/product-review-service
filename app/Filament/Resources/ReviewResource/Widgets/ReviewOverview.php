<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReviewResource\Widgets;

use App\Filament\Resources\ReviewResource\Pages\ListReviews;
use App\Models\Review;
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
        /** @var Review $pageTableQuery */
        $pageTableQuery = $this->getPageTableQuery();

        return [
            Stat::make(
                label : 'Total Reviews',
                value: $pageTableQuery
                    ->count(),
            ),
            Stat::make(
                label: 'Pending Reviews',
                value: $pageTableQuery
                    ->pending()
                    ->count(),
            ),
            Stat::make(
                label: 'Rejected Reviews',
                value: $pageTableQuery
                    ->rejected()
                    ->count(),
            ),
        ];
    }
}
