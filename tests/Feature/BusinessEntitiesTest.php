<?php

namespace Tests\Feature;

use App\Filament\Tables\BusinessTableFilters;
use App\Filament\Widgets\BusinessStatsOverview;
use App\Models\Clientes;
use App\Models\Facturas;
use App\Models\OperacionesDeVentas;
use App\Models\Productos;
use App\Models\Proveedores;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BusinessEntitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_business_entities_persist_and_resolve_their_relationships(): void
    {
        $cliente = Clientes::create([
            'nombre' => 'Ana',
            'apellido' => 'López',
            'email' => 'ana@example.test',
            'telefono' => '5551234567',
            'direccion' => 'Centro',
        ]);
        $proveedor = Proveedores::create([
            'nombre' => 'Distribuidora',
            'apellido' => 'Norte',
            'email' => 'ventas@example.test',
            'telefono' => '5557654321',
            'direccion' => 'Zona industrial',
        ]);
        $producto = Productos::create([
            'codigo' => 'P-001',
            'nombre' => 'Café',
            'descripcion' => 'Bolsa de café',
            'precio' => 125.50,
            'proveedor_id' => $proveedor->id,
        ]);
        $venta = OperacionesDeVentas::create([
            'cliente_id' => $cliente->id,
            'producto_id' => $producto->id,
            'cantidad' => 2,
            'total' => 251,
            'fecha' => '2026-10-14',
        ]);
        $factura = Facturas::create([
            'operacion_de_venta_id' => $venta->id,
            'fecha_emision' => '2026-10-14',
            'total' => 251,
        ]);

        $this->assertTrue($cliente->operacionesDeVentas->contains($venta));
        $this->assertTrue($proveedor->productos->contains($producto));
        $this->assertTrue($proveedor->operacionesDeVentas->contains($venta));
        $this->assertTrue($producto->operacionesDeVentas->contains($venta));
        $this->assertTrue($venta->cliente->is($cliente));
        $this->assertTrue($venta->producto->is($producto));
        $this->assertTrue($venta->facturas->contains($factura));
        $this->assertTrue($factura->operacionDeVenta->is($venta));
    }

    public function test_status_and_creation_date_filters_apply_the_selected_values(): void
    {
        $included = Clientes::create([
            'nombre' => 'Incluida',
            'apellido' => 'Activa',
            'email' => 'included@example.test',
            'telefono' => '5551111111',
        ]);
        Clientes::whereKey($included->id)->update(['created_at' => '2026-10-10 12:00:00']);
        $excluded = Clientes::create([
            'nombre' => 'Inactiva',
            'apellido' => 'Anterior',
            'email' => 'inactive@example.test',
            'telefono' => '5552222222',
            'active' => false,
        ]);
        Clientes::whereKey($excluded->id)->update(['created_at' => '2026-10-09 12:00:00']);

        $query = Clientes::query();
        BusinessTableFilters::status()->apply($query, ['isActive' => true, 'value' => '1']);
        $this->assertSame([$included->id], $query->pluck('id')->all());

        BusinessTableFilters::createdAtRange()->apply($query, [
            'isActive' => true,
            'created_from' => '2026-10-10',
            'created_until' => '2026-10-10',
        ]);

        $this->assertSame([$included->id], $query->pluck('id')->all());
    }

    public function test_filament_dashboard_and_all_resource_forms_render(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/admin')->assertOk();
        Livewire::test(BusinessStatsOverview::class)
            ->assertSee('Registros activos')
            ->assertSee('Clientes');

        foreach ([
            'clientes',
            'proveedores',
            'productos',
            'operaciones-de-ventas',
            'facturas',
        ] as $resource) {
            $this->get("/admin/{$resource}")->assertOk();
            $this->get("/admin/{$resource}/create")->assertOk();
        }
    }
}
