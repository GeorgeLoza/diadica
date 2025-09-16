<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto_usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'nombre',
        'cargo',
        'telefono',
        'direccion',
        'correo',    
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
