<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Coupon Details')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('e.g., SAVE20, WELCOME10')
                            ->dehydrateStateUsing(fn ($state) => strtoupper($state)),
                        Forms\Components\Select::make('type')
                            ->options([
                                'fixed' => 'Fixed Amount',
                                'percent' => 'Percentage',
                            ])
                            ->default('fixed')
                            ->required(),
                        Forms\Components\TextInput::make('value')
                            ->required()
                            ->numeric()
                            ->label('Discount Value')
                            ->helperText('Enter absolute amount for Fixed or rate (0-100) for Percentage'),
                        Forms\Components\TextInput::make('min_amount')
                            ->required()
                            ->numeric()
                            ->default(0.00)
                            ->label('Minimum Cart Subtotal'),
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Expiration Date')
                            ->placeholder('No expiration date'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->label('Is Active')
                            ->inline(false),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->fontFamily('mono')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'percent' => 'success',
                        'fixed' => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('value')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($record, $state) => $record->type === 'percent' ? $state . '%' : \Illuminate\Support\Number::currency($state, 'INR')),
                Tables\Columns\TextColumn::make('min_amount')
                    ->numeric()
                    ->sortable()
                    ->money('INR')
                    ->label('Min Cart Total'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Never Expires'),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
