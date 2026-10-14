<?php

namespace App\Filament\Resources\Productos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductosForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codigo')->label('Código')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('nombre')->label('Nombre')->required()->maxLength(255),
                Textarea::make('descripcion')->label('Descripción')->rows(3)->columnSpanFull(),
                TextInput::make('precio')->label('Precio')->numeric()->required()->minValue(0.01)->prefix('$'),
                Select::make('proveedor_id')
                    ->label('Proveedor')
                    ->relationship(
                        name: 'proveedor',
                        titleAttribute: 'nombre',
                        modifyQueryUsing: fn ($query) => $query->orderBy('nombre')->orderBy('apellido'),
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record): string => "{$record->nombre} {$record->apellido}")
                    ->searchable()
                    ->preload()
                    ->required(),
                Toggle::make('active')->label('Activo')->default(true),
            ]);
    }
}
