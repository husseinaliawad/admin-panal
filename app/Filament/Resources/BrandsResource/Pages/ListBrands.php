<?php

namespace App\Filament\Resources\BrandsResource\Pages;

use App\Filament\Resources\BrandsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
