<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProviderResource\RelationManagers;

use App\Models\Product;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected function canCreate(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\IconColumn::make('set_to_commentable_at')
                    ->label('Commentable')
                    ->boolean()
                    ->alignCenter()
                    ->getStateUsing(function (Product $record): bool {
                        return isset($record->set_to_commentable_at);
                    }),
                Tables\Columns\IconColumn::make('set_to_votable_at')
                    ->label('Votable')
                    ->boolean()
                    ->alignCenter()
                    ->getStateUsing(function (Product $record): bool {
                        return isset($record->set_to_votable_at);
                    }),
                Tables\Columns\IconColumn::make('set_to_publicly_reviewable')
                    ->label('Publicly Reviewable')
                    ->boolean()
                    ->alignCenter()
                    ->getStateUsing(function (Product $record): bool {
                        return isset($record->set_to_publicly_reviewable);
                    }),
                Tables\Columns\IconColumn::make('published_at')
                    ->label('Published')
                    ->boolean()
                    ->alignCenter()
                    ->getStateUsing(function (Product $record): bool {
                        return isset($record->published_at);
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('view')
                    ->icon('heroicon-m-eye')
                    ->color('gray')
                    ->url(fn (Product $record): string => route('filament.admin.resources.products.view', $record)),
            ]);
    }
}
