<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentDisputeResource\Pages;
use App\Models\PaymentDispute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentDisputeResource extends Resource
{
    protected static ?string $model = PaymentDispute::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Payment Settings';

    protected static ?string $navigationLabel = 'Disputes & Chargebacks';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dispute Details')
                    ->schema([
                        Forms\Components\TextInput::make('order_id')
                            ->disabled(),
                        Forms\Components\TextInput::make('gateway_dispute_id')
                            ->disabled(),
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('currency')
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'opened' => 'Opened',
                                'under_review' => 'Under Review',
                                'won' => 'Won / Resolved',
                                'lost' => 'Lost',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('reason')
                            ->disabled(),
                        Forms\Components\KeyValue::make('evidence')
                            ->label('Dispute Evidence / Log')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.id')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gateway_dispute_id')
                    ->label('Dispute ID')
                    ->fontFamily('mono')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money(fn ($record) => $record->currency)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'won' => 'success',
                        'under_review' => 'warning',
                        'lost' => 'danger',
                        'opened' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'opened' => 'Opened',
                        'under_review' => 'Under Review',
                        'won' => 'Won',
                        'lost' => 'Lost',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentDisputes::route('/'),
            'edit' => Pages\EditPaymentDispute::route('/{record}/edit'),
        ];
    }
}
