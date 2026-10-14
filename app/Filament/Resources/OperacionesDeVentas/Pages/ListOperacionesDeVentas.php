<?php

namespace App\Filament\Resources\OperacionesDeVentas\Pages;

use App\Filament\Resources\OperacionesDeVentas\OperacionesDeVentasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOperacionesDeVentas extends ListRecords
{
    protected static string $resource = OperacionesDeVentasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
