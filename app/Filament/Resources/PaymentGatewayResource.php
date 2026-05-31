<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentGatewayResource\Pages;
use App\Models\PaymentGateway;
use App\Services\Payment\PaymentGatewayManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaymentGatewayResource extends Resource
{
    protected static ?string $model = PaymentGateway::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Payment Settings';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->helperText('The customer-facing label shown on the checkout screen (e.g., Credit Card via Stripe).'),
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->disabled(fn (?PaymentGateway $record) => $record !== null)
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('A unique lowercase alphanumeric identifier code for this gateway (e.g., stripe, razorpay, paytm, custom_gw).'),
                        Forms\Components\TextInput::make('driver')
                            ->required()
                            ->disabled(fn (?PaymentGateway $record) => $record !== null)
                            ->maxLength(255)
                            ->helperText('The driver implementation key registered in config/payment.php (e.g., stripe, razorpay, paytm, cod).'),
                        Forms\Components\Select::make('environment')
                            ->options([
                                'sandbox' => 'Sandbox / Testing',
                                'live' => 'Live / Production',
                            ])
                            ->required()
                            ->helperText('Choose whether to route payments to the gateway\'s sandbox/testing environment or live production servers.'),
                        Forms\Components\TextInput::make('priority')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->helperText('Order priority (lower value = higher priority). Gateways are sorted by this value on storefront checkout.'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active Status')
                            ->required()
                            ->helperText('Enable or disable this gateway on the storefront checkout.'),
                        Forms\Components\Toggle::make('is_default')
                            ->label('Is Default Gateway')
                            ->required()
                            ->helperText('Mark this gateway as default. If active, it will be pre-selected for the customer.'),
                    ])->columns(2),

                Forms\Components\Section::make('Gateway Credentials')
                    ->description('These credentials will be safely encrypted before saving into the database.')
                    ->schema(function (Get $get, ?PaymentGateway $record) {
                        if (!$record) {
                            return [
                                Forms\Components\Placeholder::make('info')
                                    ->content('Credentials configuration is available after creation.')
                            ];
                        }

                        try {
                            $drivers = config('payment.drivers', []);
                            $driverClass = $drivers[$record->driver] ?? null;

                            if ($driverClass && class_exists($driverClass)) {
                                $driver = new $driverClass();
                                return $driver->getFormSchema();
                            }
                        } catch (\Exception $e) {
                            return [
                                Forms\Components\Placeholder::make('error')
                                    ->content('Failed to load credentials form: ' . $e->getMessage())
                            ];
                        }

                        return [
                            Forms\Components\Placeholder::make('info')
                                ->content('No credentials required for this gateway driver.')
                        ];
                    })->statePath('credentials'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->fontFamily('mono')
                    ->sortable(),
                Tables\Columns\TextColumn::make('environment')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'live' => 'danger',
                        'sandbox' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\IconColumn::make('is_default')
                    ->boolean()
                    ->label('Default'),
                Tables\Columns\TextColumn::make('priority')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('health_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'healthy' => 'success',
                        'degraded' => 'warning',
                        'down' => 'danger',
                        default => 'gray',
                    })
                    ->label('Health'),
                Tables\Columns\TextColumn::make('last_health_check_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->query(fn (Builder $query) => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('checkHealth')
                    ->label('Check Health')
                    ->icon('heroicon-o-bolt')
                    ->color('info')
                    ->action(function (PaymentGateway $record) {
                        $manager = app(PaymentGatewayManager::class);
                        $result = $manager->syncHealth($record->code);

                        if ($result->healthy) {
                            Notification::make()
                                ->success()
                                ->title("Gateway {$record->name} is Healthy")
                                ->body("Latency: {$result->latencyMs}ms")
                                ->send();
                        } else {
                            Notification::make()
                                ->danger()
                                ->title("Gateway {$record->name} is degraded or unreachable")
                                ->body($result->message)
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentGateways::route('/'),
            'create' => Pages\CreatePaymentGateway::route('/create'),
            'edit' => Pages\EditPaymentGateway::route('/{record}/edit'),
        ];
    }
}
