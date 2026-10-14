<?php

namespace App\Filament\Resources\Facturas\Tables;

use App\Filament\Tables\BusinessTableFilters;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FacturasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('operacion_de_venta_id')
                    ->label('Operación')
                    ->formatStateUsing(fn ($state, $record): string => $record->operacionDeVenta
                        ? "{$record->operacionDeVenta->cliente->nombre} {$record->operacionDeVenta->cliente->apellido} - {$record->operacionDeVenta->fecha}"
                        : '')
                    ->searchable(),
                TextColumn::make('fecha_emision')->label('Emisión')->date()->sortable(),
                TextColumn::make('total')->label('Total')->numeric(decimalPlaces: 2)->sortable(),
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
