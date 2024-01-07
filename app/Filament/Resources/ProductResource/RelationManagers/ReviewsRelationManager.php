<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Enums\ReviewStatus;
use App\Models\Review;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    protected function canCreate(): bool
    {
        return false;
    }

    protected function canEdit(Model $record): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('product.name')
                    ->url(function (Review $record): string {
                        return route('filament.admin.resources.products.view', $record->product_id);
                    })
                    ->color('warning'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(function (Review $record): string {
                        return ReviewStatus::tryFrom($record->status)->color();
                    })
                    ->getStateUsing(function (Review $record): string {
                        return ReviewStatus::tryFrom($record->status)->label();
                    }),
                Tables\Columns\TextColumn::make('vote'),
                Tables\Columns\TextColumn::make('comment')
                    ->limit(50),
            ])
            ->filters([
                //
            ])->actions([
                Action::make('change_status')
                    ->icon('heroicon-o-arrow-path')
                    ->modalWidth(MaxWidth::Medium)
                    ->color('info')
                    ->form([
                        Select::make('status')
                            ->options(ReviewStatus::options())
                            ->required(),
                    ])
                    ->action(function (array $data, Review $record): void {
                        $record->status = $data['status'];
                        $record->save();

                        Notification::make()
                            ->title('Status updated successfully!')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
