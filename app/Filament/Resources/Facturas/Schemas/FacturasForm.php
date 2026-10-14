<?php

namespace App\Filament\Resources\Facturas\Schemas;

use App\Models\OperacionesDeVentas;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FacturasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('operacion_de_venta_id')
                    ->label('Operación de venta')
                    ->relationship(
                        name: 'operacionDeVenta',
                        titleAttribute: 'fecha',
                        modifyQueryUsing: fn ($query) => $query->with('cliente')->orderByDesc('fecha'),
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (OperacionesDeVentas $record): string => "{$record->cliente->nombre} {$record->cliente->apellido} - {$record->fecha} - \${$record->total}",
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('fecha_emision')->label('Fecha de emisión')->required(),
                TextInput::make('total')->label('Total')->numeric()->required()->minValue(0.01)->prefix('$'),
                Toggle::make('active')->label('Activo')->default(true),
            ]);
    }
}
