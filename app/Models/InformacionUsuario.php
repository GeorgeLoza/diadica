<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionUsuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'direccion',
        'empresa',
        'razon_social',
        'nit',
    ];

    /**
     * Get the user that owns the information.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
