<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provider_id')
                    ->relationship('provider', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('set_to_commentable_at')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('set_to_votable_at')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('set_to_publicly_reviewable')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('provider.name')
                    ->url(function (Product $record): string {
                        return route('filament.admin.resources.providers.view', $record->provider_id);
                    })
                    ->color('warning'),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
