<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bobina extends Model
{
     use HasFactory;

    protected $fillable = [
        'producto_id',
        'peso_kg',
        'lote',
        'fecha_ingreso',
        'estado',
        'costo_unitario',
        'observaciones',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
