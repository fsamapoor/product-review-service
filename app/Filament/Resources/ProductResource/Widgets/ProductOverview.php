<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Models\Product;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListProducts::class;
    }

    protected function getStats(): array
    {
        /** @var Product $pageTableQuery */
        $pageTableQuery = $this->getPageTableQuery();

        return [
            Stat::make(
                label : 'Total Products',
                value: $pageTableQuery
                    ->count(),
            ),
            Stat::make(
                label: 'Published Products',
                value: $pageTableQuery
                    ->published()
                    ->count(),
            ),
            Stat::make(
                label: 'Commentable Products',
                value: $pageTableQuery
                    ->commentable()
                    ->count(),
            ),
            Stat::make(
                label: 'Votable Products',
                value: $pageTableQuery
                    ->votable()
                    ->count(),
            ),
        ];
    }
}
