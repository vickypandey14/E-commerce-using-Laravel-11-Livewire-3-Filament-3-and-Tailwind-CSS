<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryLogResource\Pages;
use App\Models\InventoryLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InventoryLogResource extends Resource
{
    protected static ?string $model = InventoryLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Inventory Logs / Audit';

    protected static ?int $navigationSort = 13;

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Stock Adjustment Details')
                    ->description('Create a manual inventory audit adjustment log. Stock levels can be updated here.')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Product'),
                        Forms\Components\TextInput::make('quantity_change')
                            ->integer()
                            ->required()
                            ->placeholder('e.g. 10 or -5')
                            ->label('Quantity Adjustment'),
                        Forms\Components\TextInput::make('reason')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Restock, Damage Write-off, Stock Count Alignment')
                            ->label('Adjustment Reason'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Adjusted By')
                    ->placeholder('System / Purchase')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_change')
                    ->label('Quantity Change')
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger')
                    ->formatStateUsing(fn ($state) => ($state > 0 ? '+' : '') . $state)
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Logged At'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('product')
                    ->relationship('product', 'name'),
                Tables\Filters\Filter::make('positive_adjustments')
                    ->label('Additions Only')
                    ->query(fn ($query) => $query->where('quantity_change', '>', 0)),
                Tables\Filters\Filter::make('negative_adjustments')
                    ->label('Reductions Only')
                    ->query(fn ($query) => $query->where('quantity_change', '<', 0)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk actions to preserve audit integrity
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
            'index' => Pages\ListInventoryLogs::route('/'),
            'create' => Pages\CreateInventoryLog::route('/create'),
        ];
    }
}
