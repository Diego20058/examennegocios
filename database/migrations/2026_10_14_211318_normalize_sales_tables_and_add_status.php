<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('OperacionesDeVentas') && ! Schema::hasTable('operaciones_de_ventas')) {
            Schema::rename('OperacionesDeVentas', 'operaciones_de_ventas');
        }

        foreach (['clientes', 'productos', 'operaciones_de_ventas'] as $tableName) {
            if (Schema::hasTable($tableName) && ! Schema::hasColumn($tableName, 'active')) {
                Schema::table($tableName, function (Blueprint $table): void {
                    $table->boolean('active')->default(true);
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['clientes', 'productos', 'operaciones_de_ventas'] as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'active')) {
                Schema::table($tableName, function (Blueprint $table): void {
                    $table->dropColumn('active');
                });
            }
        }

        if (Schema::hasTable('operaciones_de_ventas') && ! Schema::hasTable('OperacionesDeVentas')) {
            Schema::rename('operaciones_de_ventas', 'OperacionesDeVentas');
        }
    }
};
