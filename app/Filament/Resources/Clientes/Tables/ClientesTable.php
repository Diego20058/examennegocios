<?php

namespace App\Filament\Resources\Clientes\Tables;

use App\Filament\Tables\BusinessTableFilters;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Cliente')
                    ->formatStateUsing(fn (string $state, $record): string => "{$state} {$record->apellido}")
                    ->searchable(['nombre', 'apellido'])
                    ->sortable(),
                TextColumn::make('email')->label('Correo')->searchable(),
                TextColumn::make('telefono')->label('Teléfono')->searchable(),
                TextColumn::make('active')
                    ->label('Estado')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Activo' : 'Inactivo')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
                TextColumn::make('created_at')->label('Creado')->dateTime()->sortable(),
            ])
            ->filters([
                BusinessTableFilters::status(),
                BusinessTableFilters::createdAtRange(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
