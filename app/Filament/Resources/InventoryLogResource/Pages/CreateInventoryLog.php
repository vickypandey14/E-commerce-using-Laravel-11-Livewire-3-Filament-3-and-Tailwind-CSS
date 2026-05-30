<?php

namespace App\Filament\Resources\InventoryLogResource\Pages;

use App\Filament\Resources\InventoryLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInventoryLog extends CreateRecord
{
    protected static string $resource = InventoryLogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
