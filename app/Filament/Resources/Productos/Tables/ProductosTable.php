<?php

namespace App\Filament\Resources\Productos\Tables;

use App\Filament\Tables\BusinessTableFilters;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('codigo')->label('Código')->searchable()->sortable(),
                TextColumn::make('nombre')->label('Producto')->searchable()->sortable(),
                TextColumn::make('proveedor.nombre')
                    ->label('Proveedor')
                    ->formatStateUsing(fn ($state, $record): string => $record->proveedor
                        ? "{$record->proveedor->nombre} {$record->proveedor->apellido}"
                        : ''),
                TextColumn::make('precio')->label('Precio')->numeric(decimalPlaces: 2)->sortable(),
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
