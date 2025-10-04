<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'lugar_pago',
        'recibi_de',
        'tiempo',
        'tipo_pago',
        'concepto',
        'comprobante',
        'monto',
        'moneda',
        'total',
        'estado',
        'trabajador_id',
        'cliente_id',
    ];

    public function trabajador()
    {
        return $this->belongsTo(User::class, 'trabajador_id');
    }
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
