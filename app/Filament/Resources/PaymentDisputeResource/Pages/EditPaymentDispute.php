<?php

namespace App\Filament\Resources\PaymentDisputeResource\Pages;

use App\Filament\Resources\PaymentDisputeResource;
use Filament\Resources\Pages\EditRecord;

class EditPaymentDispute extends EditRecord
{
    protected static string $resource = PaymentDisputeResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
