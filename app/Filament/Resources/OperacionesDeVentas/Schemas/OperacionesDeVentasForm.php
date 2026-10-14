<?php

namespace App\Filament\Resources\OperacionesDeVentas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OperacionesDeVentasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cliente_id')
                    ->label('Cliente')
                    ->relationship(
                        name: 'cliente',
                        titleAttribute: 'nombre',
                        modifyQueryUsing: fn ($query) => $query->orderBy('nombre')->orderBy('apellido'),
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record): string => "{$record->nombre} {$record->apellido}")
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('producto_id')
                    ->label('Producto')
                    ->relationship(
                        name: 'producto',
                        titleAttribute: 'nombre',
                        modifyQueryUsing: fn ($query) => $query->orderBy('nombre'),
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('cantidad')->label('Cantidad')->integer()->required()->minValue(1),
                TextInput::make('total')->label('Total')->numeric()->required()->minValue(0.01)->prefix('$'),
                DatePicker::make('fecha')->label('Fecha de venta')->required(),
                Toggle::make('active')->label('Activo')->default(true),
            ]);
    }
}
