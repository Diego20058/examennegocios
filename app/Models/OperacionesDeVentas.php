<?php

namespace App\Models;

use Database\Factories\OperacionesDeVentasFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperacionesDeVentas extends Model
{
    protected $table = 'operaciones_de_ventas';

    protected $fillable = [
        'cliente_id',
        'producto_id',
        'cantidad',
        'total',
        'fecha',
        'active',
    ];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }

    /** @use HasFactory<OperacionesDeVentasFactory> */
    use HasFactory;

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }

    public function facturas()
    {
        return $this->hasMany(Facturas::class, 'operacion_de_venta_id');
    }
}
