<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'active',
    ];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }

    public function productos()
    {
        return $this->hasMany(Productos::class, 'proveedor_id');
    }

    public function operacionesDeVentas()
    {
        return $this->hasManyThrough(OperacionesDeVentas::class, Productos::class, 'proveedor_id', 'producto_id');
    }
}
