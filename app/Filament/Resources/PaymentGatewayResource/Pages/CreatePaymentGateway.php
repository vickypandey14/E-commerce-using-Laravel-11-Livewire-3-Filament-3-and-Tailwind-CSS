<?php

namespace App\Filament\Resources\PaymentGatewayResource\Pages;

use App\Filament\Resources\PaymentGatewayResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentGateway extends CreateRecord
{
    protected static string $resource = PaymentGatewayResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Enforce default behavior sync
        if ($data['is_default'] ?? false) {
            \App\Models\PaymentGateway::where('is_default', true)->update(['is_default' => false]);
        }
        return $data;
    }
}
