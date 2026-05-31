<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentTransactionResource\Pages;
use App\Models\PaymentTransaction;
use App\Models\PaymentRefund;
use App\Services\Payment\PaymentGatewayManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaymentTransactionResource extends Resource
{
    protected static ?string $model = PaymentTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Payment Settings';

    protected static ?string $navigationLabel = 'Transactions Log';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Transaction Details')
                    ->schema([
                        Forms\Components\TextInput::make('order_id')
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('user.name')
                            ->label('Customer')
                            ->disabled(),
                        Forms\Components\TextInput::make('gateway_code')
                            ->disabled(),
                        Forms\Components\TextInput::make('gateway_transaction_id')
                            ->disabled(),
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('currency')
                            ->disabled(),
                        Forms\Components\TextInput::make('status')
                            ->disabled(),
                        Forms\Components\TextInput::make('type')
                            ->disabled(),
                        Forms\Components\Textarea::make('error_message')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('payload')
                            ->label('Raw Payload Response')
                            ->disabled()
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gateway_code')
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gateway_transaction_id')
                    ->label('Gateway ID')
                    ->fontFamily('mono')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money(fn ($record) => $record->currency)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'refunded' => 'info',
                        'partially_refunded' => 'warning',
                        'failed' => 'danger',
                        'pending' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gateway_code')
                    ->options([
                        'stripe' => 'Stripe',
                        'razorpay' => 'Razorpay',
                        'paytm' => 'Paytm',
                        'cod' => 'Cash on Delivery',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                
                // Manual Sync Action
                Tables\Actions\Action::make('syncStatus')
                    ->label('Sync Gateway')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->action(function (PaymentTransaction $record) {
                        $manager = app(PaymentGatewayManager::class);
                        try {
                            $driver = $manager->driver($record->gateway_code);
                            $response = $driver->syncPaymentStatus($record);

                            if ($response->success) {
                                $record->update([
                                    'status' => $response->status,
                                    'payload' => array_merge($record->payload ?? [], $response->rawPayload)
                                ]);

                                // Sync Order payment status if completed
                                if ($response->status === 'completed') {
                                    $record->order->update([
                                        'payment_status' => 'paid',
                                        'status' => 'processing',
                                    ]);
                                }

                                Notification::make()
                                    ->success()
                                    ->title('Status Synced Successfully')
                                    ->body("Gateway status: {$response->status}")
                                    ->send();
                            } else {
                                Notification::make()
                                    ->danger()
                                    ->title('Sync Failed')
                                    ->body($response->errorMessage)
                                    ->send();
                            }
                        } catch (\Exception $e) {
                            Notification::make()
                                ->danger()
                                ->title('Sync Failed')
                                ->body($e->getMessage())
                                ->send();
                        }
                    })
                    ->visible(fn (PaymentTransaction $record) => $record->status === 'pending'),

                // Issue Refund Action
                Tables\Actions\Action::make('refund')
                    ->label('Refund')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('danger')
                    ->form([
                        Forms\Components\TextInput::make('refund_amount')
                            ->label('Refund Amount')
                            ->numeric()
                            ->required()
                            ->helperText(fn (PaymentTransaction $record) => 'Max refundable amount: INR ' . $record->amount),
                        Forms\Components\TextInput::make('reason')
                            ->label('Reason')
                            ->required(),
                    ])
                    ->action(function (PaymentTransaction $record, array $data) {
                        $refundAmount = (float) $data['refund_amount'];
                        
                        if ($refundAmount <= 0 || $refundAmount > $record->amount) {
                            Notification::make()
                                ->danger()
                                ->title('Invalid Amount')
                                ->body('Refund amount cannot exceed the transaction amount.')
                                ->send();
                            return;
                        }

                        $manager = app(PaymentGatewayManager::class);
                        try {
                            $driver = $manager->driver($record->gateway_code);

                            // Create initial pending refund model
                            $refundModel = PaymentRefund::create([
                                'transaction_id' => $record->id,
                                'order_id' => $record->order_id,
                                'amount' => $refundAmount,
                                'reason' => $data['reason'],
                                'status' => 'pending',
                            ]);

                            $response = $driver->refund($record, $refundAmount, $data['reason']);

                            if ($response->success) {
                                $refundModel->update([
                                    'gateway_refund_id' => $response->refundId,
                                    'status' => 'processed',
                                    'metadata' => $response->rawPayload
                                ]);

                                // Update transaction and order status
                                $newStatus = ($refundAmount == $record->amount) ? 'refunded' : 'partially_refunded';
                                $record->update(['status' => $newStatus]);
                                $record->order->update(['payment_status' => $newStatus]);

                                // Fire refund event
                                event(new \App\Events\RefundProcessed($refundModel));

                                Notification::make()
                                    ->success()
                                    ->title('Refund Processed')
                                    ->body("Successfully refunded INR {$refundAmount}")
                                    ->send();
                            } else {
                                $refundModel->update(['status' => 'failed', 'metadata' => $response->rawPayload]);
                                Notification::make()
                                    ->danger()
                                    ->title('Refund Failed')
                                    ->body($response->errorMessage)
                                    ->send();
                            }
                        } catch (\Exception $e) {
                            Notification::make()
                                ->danger()
                                ->title('Refund Process Failed')
                                ->body($e->getMessage())
                                ->send();
                        }
                    })
                    ->visible(fn (PaymentTransaction $record) => $record->status === 'completed' && $record->type === 'payment'),
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
            'index' => Pages\ListPaymentTransactions::route('/'),
        ];
    }
}
