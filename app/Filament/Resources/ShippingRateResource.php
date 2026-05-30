<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShippingRateResource\Pages;
use App\Filament\Resources\ShippingRateResource\RelationManagers;
use App\Models\ShippingRate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShippingRateResource extends Resource
{
    protected static ?string $model = ShippingRate::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Shipping Rate Details')
                    ->schema([
                        Forms\Components\TextInput::make('shipping_method')
                            ->placeholder('e.g., Express Delivery, Standard Shipping')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('zone_name')
                            ->placeholder('e.g., Domestic, International, Metro')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('cost')
                            ->required()
                            ->numeric()
                            ->prefix('INR')
                            ->label('Shipping Cost'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->label('Is Active')
                            ->inline(false),
                    ])->columns(2),

                Forms\Components\Section::make('Estimated Delivery Time')
                    ->schema([
                        Forms\Components\TextInput::make('min_delivery_days')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->label('Minimum Days'),
                        Forms\Components\TextInput::make('max_delivery_days')
                            ->required()
                            ->numeric()
                            ->default(7)
                            ->label('Maximum Days'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('shipping_method')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('zone_name')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('cost')
                    ->money('INR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_range')
                    ->label('Estimated Delivery')
                    ->formatStateUsing(fn ($record) => $record->min_delivery_days . ' - ' . $record->max_delivery_days . ' Days')
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderBy('min_delivery_days', $direction);
                    }),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()->requiresConfirmation(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListShippingRates::route('/'),
            'create' => Pages\CreateShippingRate::route('/create'),
            'edit' => Pages\EditShippingRate::route('/{record}/edit'),
        ];
    }
}
