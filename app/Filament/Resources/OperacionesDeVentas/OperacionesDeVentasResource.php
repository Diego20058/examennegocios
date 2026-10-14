<?php

namespace App\Filament\Resources\OperacionesDeVentas;

use App\Filament\Resources\OperacionesDeVentas\Pages\CreateOperacionesDeVentas;
use App\Filament\Resources\OperacionesDeVentas\Pages\EditOperacionesDeVentas;
use App\Filament\Resources\OperacionesDeVentas\Pages\ListOperacionesDeVentas;
use App\Filament\Resources\OperacionesDeVentas\Schemas\OperacionesDeVentasForm;
use App\Filament\Resources\OperacionesDeVentas\Tables\OperacionesDeVentasTable;
use App\Models\OperacionesDeVentas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OperacionesDeVentasResource extends Resource
{
    protected static ?string $model = OperacionesDeVentas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return OperacionesDeVentasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OperacionesDeVentasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOperacionesDeVentas::route('/'),
            'create' => CreateOperacionesDeVentas::route('/create'),
            'edit' => EditOperacionesDeVentas::route('/{record}/edit'),
        ];
    }
}
