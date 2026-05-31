<?php

namespace App\Filament\Resources\PaymentRefundResource\Pages;

use App\Filament\Resources\PaymentRefundResource;
use Filament\Resources\Pages\ListRecords;

class ListPaymentRefunds extends ListRecords
{
    protected static string $resource = PaymentRefundResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
