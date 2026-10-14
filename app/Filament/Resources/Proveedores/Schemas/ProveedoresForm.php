<?php

namespace App\Filament\Resources\Proveedores\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProveedoresForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')->label('Nombre')->required()->maxLength(255),
                TextInput::make('apellido')->label('Apellido')->required()->maxLength(255),
                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('telefono')->label('Teléfono')->tel()->required()->maxLength(30),
                Textarea::make('direccion')->label('Dirección')->rows(3)->columnSpanFull(),
                Toggle::make('active')->label('Activo')->default(true),
            ]);
    }
}
