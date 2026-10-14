<?php

namespace App\Filament\Resources\OperacionesDeVentas\Pages;

use App\Filament\Resources\OperacionesDeVentas\OperacionesDeVentasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOperacionesDeVentas extends EditRecord
{
    protected static string $resource = OperacionesDeVentasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
