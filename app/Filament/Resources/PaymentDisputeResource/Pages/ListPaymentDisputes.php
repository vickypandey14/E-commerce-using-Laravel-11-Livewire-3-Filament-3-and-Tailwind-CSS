<?php

namespace App\Filament\Resources\PaymentDisputeResource\Pages;

use App\Filament\Resources\PaymentDisputeResource;
use Filament\Resources\Pages\ListRecords;

class ListPaymentDisputes extends ListRecords
{
    protected static string $resource = PaymentDisputeResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
