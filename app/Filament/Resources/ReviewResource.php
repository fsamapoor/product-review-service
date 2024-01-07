<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ReviewStatus;
use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Review service';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->formatStateUsing(function (Review $record): string {
                        return $record->user->name;
                    }),
                Forms\Components\TextInput::make('product_id')
                    ->formatStateUsing(function (Review $record): string {
                        return $record->product->name;
                    }),
                Forms\Components\TextInput::make('status')
                    ->formatStateUsing(function (int $state): string {
                        return ReviewStatus::tryFrom($state)->label();
                    }),
                Forms\Components\TextInput::make('vote'),
                Forms\Components\Textarea::make('comment')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->url(function (Review $record): string {
                        return route('filament.admin.resources.users.view', $record->user_id);
                    })
                    ->color('warning'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
        ];
    }
}
