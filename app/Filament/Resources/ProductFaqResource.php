<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductFaqResource\Pages;
use App\Models\ProductFaq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductFaqResource extends Resource
{
    protected static ?string $model = ProductFaq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('FAQ details')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Product'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->label('Active for Display')
                            ->inline(false),
                        Forms\Components\TextInput::make('question')
                            ->required()
                            ->maxLength(255)
                            ->label('Question')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('answer')
                            ->rows(4)
                            ->required()
                            ->columnSpanFull()
                            ->label('Answer'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('question')
                    ->label('Question')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('answer')
                    ->label('Answer')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All FAQs')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListProductFaqs::route('/'),
            'create' => Pages\CreateProductFaq::route('/create'),
            'edit' => Pages\EditProductFaq::route('/{record}/edit'),
        ];
    }
}
