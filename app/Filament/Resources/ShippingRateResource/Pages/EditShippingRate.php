<?php

namespace App\Filament\Resources\ShippingRateResource\Pages;

use App\Filament\Resources\ShippingRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShippingRate extends EditRecord
{
    protected static string $resource = ShippingRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
