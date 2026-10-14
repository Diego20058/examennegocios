<?php

namespace App\Filament\Resources\Facturas;

use App\Filament\Resources\Facturas\Pages\CreateFacturas;
use App\Filament\Resources\Facturas\Pages\EditFacturas;
use App\Filament\Resources\Facturas\Pages\ListFacturas;
use App\Filament\Resources\Facturas\Schemas\FacturasForm;
use App\Filament\Resources\Facturas\Tables\FacturasTable;
use App\Models\Facturas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FacturasResource extends Resource
{
    protected static ?string $model = Facturas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return FacturasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FacturasTable::configure($table);
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
            'index' => ListFacturas::route('/'),
            'create' => CreateFacturas::route('/create'),
            'edit' => EditFacturas::route('/{record}/edit'),
        ];
    }
}
