<?php

namespace App\Filament\Tables;

use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class BusinessTableFilters
{
    public static function status(): SelectFilter
    {
        return SelectFilter::make('active')
            ->label('Estado')
            ->options([
                1 => 'Activo',
                0 => 'Inactivo',
            ]);
    }

    public static function createdAtRange(): Filter
    {
        return Filter::make('created_at')
            ->label('Fecha de creación')
            ->schema([
                DatePicker::make('created_from')->label('Desde'),
                DatePicker::make('created_until')->label('Hasta'),
            ])
            ->columns(2)
            ->query(fn (Builder $query, array $data): Builder => $query
                ->when(
                    $data['created_from'] ?? null,
                    fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '>=', $date),
                )
                ->when(
                    $data['created_until'] ?? null,
                    fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '<=', $date),
                ));
    }
}
