<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')->schema([

                        TextInput::make('name')
                            ->label('Product Name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, $operation, $set) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            })
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('generateAIDescription')
                                    ->label('Generate AI Description')
                                    ->icon('heroicon-o-sparkles')
                                    ->color('primary')
                                    ->action(function (Forms\Get $get, Forms\Set $set, $state) {
                                        if (empty($state)) {
                                            \Filament\Notifications\Notification::make()
                                                ->warning()
                                                ->title('Product Name Required')
                                                ->body('Please type a product name first before generating.')
                                                ->send();
                                            return;
                                        }

                                        $categoryId = $get('category_id');
                                        $brandId = $get('brand_id');

                                        $categoryName = $categoryId ? \App\Models\Category::find($categoryId)?->name : 'Electronics';
                                        $brandName = $brandId ? \App\Models\Brand::find($brandId)?->name : null;

                                        \Filament\Notifications\Notification::make()
                                            ->info()
                                            ->title('AI Copywriter Active')
                                            ->body('Writing description with Gemini API...')
                                            ->send();

                                        $service = app(\App\Services\Ai\GeminiService::class);
                                        $description = $service->generateProductDescription($state, $categoryName, $brandName);

                                        if ($description) {
                                            $set('description', $description);
                                            \Filament\Notifications\Notification::make()
                                                ->success()
                                                ->title('Description Generated!')
                                                ->send();
                                        } else {
                                            \Filament\Notifications\Notification::make()
                                                ->danger()
                                                ->title('AI Copywriter Failed')
                                                ->body('Verify your Gemini API key in Store Settings.')
                                                ->send();
                                        }
                                    })
                            ),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated()
                            ->unique(Product::class, 'slug', ignoreRecord: true),

                        MarkdownEditor::make('description')
                            ->columnSpanFull()
                            ->label('Long Description')
                            ->fileAttachmentsDirectory('products'),

                        MarkdownEditor::make('short_description')
                            ->columnSpanFull()
                            ->label('Short Description')
                            ->fileAttachmentsDirectory('products'),

                        TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                            
                    ])->columns(2),

                    Section::make('Images')->schema([
                        FileUpload::make('images')
                            ->multiple()
                            ->directory('products')
                            ->maxFiles(5)
                            ->reorderable()
                    ]),

                    Section::make('SEO Data')->schema([
                        
                        TextInput::make('meta_title')
                            ->maxLength(255)
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('generateAISeo')
                                    ->label('Generate AI SEO')
                                    ->icon('heroicon-o-sparkles')
                                    ->color('primary')
                                    ->action(function (Forms\Get $get, Forms\Set $set) {
                                        $name = $get('name');
                                        $desc = $get('description') ?: $get('short_description') ?: '';

                                        if (empty($name)) {
                                            \Filament\Notifications\Notification::make()
                                                ->warning()
                                                ->title('Product Name Required')
                                                ->body('Please type a product name first.')
                                                ->send();
                                            return;
                                        }

                                        \Filament\Notifications\Notification::make()
                                            ->info()
                                            ->title('SEO Optimizer Active')
                                            ->body('Writing tags with Gemini API...')
                                            ->send();

                                        $service = app(\App\Services\Ai\GeminiService::class);
                                        $seo = $service->generateSeoTags($name, strip_tags($desc));

                                        $set('meta_title', $seo['meta_title']);
                                        $set('meta_description', $seo['meta_description']);

                                        \Filament\Notifications\Notification::make()
                                            ->success()
                                            ->title('SEO Tags Generated & Applied!')
                                            ->send();
                                    })
                            ),

                        Textarea::make('meta_description')
                            ->autosize(),

                        TextInput::make('meta_keywords')
                            ->maxLength(255),

                    ])
                ])->columnSpan(2),

                Group::make()->schema([

                    Section::make('Price')->schema([
                        TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->prefix('INR')
                    ]),

                    Section::make('Associations')->schema([

                        Select::make('category_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('category', 'name')
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('suggestCategory')
                                    ->label('AI Suggest Category')
                                    ->icon('heroicon-o-sparkles')
                                    ->color('primary')
                                    ->action(function (Forms\Get $get, Forms\Set $set) {
                                        $name = $get('name');
                                        $desc = $get('description') ?: $get('short_description') ?: '';

                                        if (empty($name)) {
                                            \Filament\Notifications\Notification::make()
                                                ->warning()
                                                ->title('Product Name Required')
                                                ->body('Please type a product name first.')
                                                ->send();
                                            return;
                                        }

                                        \Filament\Notifications\Notification::make()
                                            ->info()
                                            ->title('AI Categorizer Active')
                                            ->body('Analyzing category with Gemini API...')
                                            ->send();

                                        $service = app(\App\Services\Ai\GeminiService::class);
                                        $categoryName = $service->suggestCategory($name, strip_tags($desc));

                                        if ($categoryName) {
                                            $category = \App\Models\Category::where('name', 'like', "%{$categoryName}%")->first();
                                            if ($category) {
                                                $set('category_id', $category->id);
                                                \Filament\Notifications\Notification::make()
                                                    ->success()
                                                    ->title("Categorized: {$category->name}")
                                                    ->send();
                                            } else {
                                                \Filament\Notifications\Notification::make()
                                                    ->warning()
                                                    ->title('Category Not Mapped')
                                                    ->body("AI suggested '{$categoryName}', but category was not found in database.")
                                                    ->send();
                                            }
                                        } else {
                                            \Filament\Notifications\Notification::make()
                                                ->danger()
                                                ->title('AI Categorizer Failed')
                                                ->body('Verify your Gemini API key in Store Settings.')
                                                ->send();
                                        }
                                    })
                            ),

                        Select::make('brand_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('brand', 'name'),
                    ]),

                    Section::make('Status')->schema([

                        Toggle::make('in_stock')
                            ->required()
                            ->default(true),

                        Toggle::make('is_active')
                            ->required()
                            ->default(true),

                        Toggle::make('is_featured')
                            ->required(),

                        Toggle::make('on_sale')
                            ->required(),

                    ])

                ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('brand.name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->money('INR')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active'),

                Tables\Columns\ToggleColumn::make('is_featured'),

                Tables\Columns\ToggleColumn::make('in_stock'),

                Tables\Columns\ToggleColumn::make('on_sale'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name'),

                SelectFilter::make('brand')
                    ->relationship('brand', 'name'),

                Filter::make('is_featured')
                    ->toggle(),

                Filter::make('in_stock')
                    ->toggle(),

                Filter::make('on_sale')
                    ->toggle(),

                Filter::make('is_active')
                    ->toggle()
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()->requiresConfirmation(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FaqsRelationManager::class,
            RelationManagers\InventoryLogsRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['category', 'brand']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
