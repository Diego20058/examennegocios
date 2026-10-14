<?php

namespace App\Filament\Resources\OperacionesDeVentas\Tables;

use App\Filament\Tables\BusinessTableFilters;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OperacionesDeVentasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cliente.nombre')
                    ->label('Cliente')
                    ->formatStateUsing(fn ($state, $record): string => $record->cliente
                        ? "{$record->cliente->nombre} {$record->cliente->apellido}"
                        : '')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('producto.nombre')->label('Producto')->searchable()->sortable(),
                TextColumn::make('cantidad')->label('Cantidad')->sortable(),
                TextColumn::make('total')->label('Total')->numeric(decimalPlaces: 2)->sortable(),
                TextColumn::make('fecha')->label('Fecha de venta')->date()->sortable(),
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
