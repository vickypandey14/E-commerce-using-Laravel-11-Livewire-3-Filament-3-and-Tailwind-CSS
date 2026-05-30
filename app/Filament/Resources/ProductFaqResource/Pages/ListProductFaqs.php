<?php

namespace App\Filament\Resources\ProductFaqResource\Pages;

use App\Filament\Resources\ProductFaqResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductFaqs extends ListRecords
{
    protected static string $resource = ProductFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
