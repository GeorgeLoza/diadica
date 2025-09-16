<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicaciones_usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'nombre',
        'observaciones',
        'url_map',
        'persona_referencia',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
