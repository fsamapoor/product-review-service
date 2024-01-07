<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Filament\Resources\ProductResource\Pages\ListProducts;
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
        return [
            Stat::make(
                label : 'Total Products',
                value: $this->getPageTableQuery()
                    ->count(),
            ),
            Stat::make(
                label: 'Published Products',
                value: $this->getPageTableQuery()
                    ->published()
                    ->count(),
            ),
            Stat::make(
                label: 'Commentable Products',
                value: $this->getPageTableQuery()
                    ->commentable()
                    ->count(),
            ),
            Stat::make(
                label: 'Votable Products',
                value: $this->getPageTableQuery()
                    ->votable()
                    ->count(),
            ),
        ];
    }
}
