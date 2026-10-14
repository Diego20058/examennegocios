<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    use HasFactory;

    protected $table = 'facturas';

    protected $fillable = [
        'operacion_de_venta_id',
        'fecha_emision',
        'total',
        'active',
    ];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }

    public function operacionDeVenta()
    {
        return $this->belongsTo(OperacionesDeVentas::class, 'operacion_de_venta_id');
    }
}
