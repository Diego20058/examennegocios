<?php

namespace App\Filament\Widgets;

use App\Models\Clientes;
use App\Models\Facturas;
use App\Models\OperacionesDeVentas;
use App\Models\Productos;
use App\Models\Proveedores;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BusinessStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $activeRecords = Clientes::where('active', true)->count()
            + Proveedores::where('active', true)->count()
            + Productos::where('active', true)->count()
            + OperacionesDeVentas::where('active', true)->count()
            + Facturas::where('active', true)->count();

        return [
            Stat::make('Clientes', Clientes::count()),
            Stat::make('Proveedores', Proveedores::count()),
            Stat::make('Productos', Productos::count()),
            Stat::make('Ventas', OperacionesDeVentas::count()),
            Stat::make('Facturas', Facturas::count()),
            Stat::make('Registros activos', $activeRecords)
                ->description('Total en los cinco módulos'),
        ];
    }
}
