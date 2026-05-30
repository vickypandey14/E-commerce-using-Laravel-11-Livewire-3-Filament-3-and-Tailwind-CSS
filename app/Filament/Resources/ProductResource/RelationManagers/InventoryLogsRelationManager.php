<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class InventoryLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'inventoryLogs';

    protected static ?string $title = 'Inventory Logs / Audit Trail';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
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
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
