<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
        use HasFactory;

    protected $fillable = [
        'nombre_empresa',
        'nombre_cliente',
        'nit_ci',
        'telefono',
        'direccion',
        'credito',
        'saldo',
        'fecha_registro',
        'estado',
    ];
}
