<?php

namespace App\Filament\Resources\PaymentPayoutResource\Pages;

use App\Filament\Resources\PaymentPayoutResource;
use Filament\Resources\Pages\ListRecords;

class ListPaymentPayouts extends ListRecords
{
    protected static string $resource = PaymentPayoutResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
