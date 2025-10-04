<?php

namespace App\Livewire\Extracto;

use Livewire\Component;
use App\Models\Venta;
use App\Models\Pago;
use App\Models\User;

class ExtractoDetalle extends Component
{
    public $cliente;
    public $movimientos = [];
    public $saldo = 0;

    // recibe el parámetro {id} de la ruta
    public function mount($id)
    {
        $this->cliente = User::findOrFail($id);

        $ventas = Venta::where('cliente_id', $id)
            ->select('id', 'fecha_venta as fecha', 'total as monto')
            ->get()
            ->map(function ($venta) {
                return [
                    'fecha' => $venta->fecha,
                    'concepto' => "Venta #{$venta->id}",
                    'tipo' => 'venta',
                    'monto' => -$venta->monto,
                ];
            });

        $pagos = Pago::where('cliente_id', $id)
            ->select('id', 'created_at as fecha', 'monto', 'concepto')
            ->get()
            ->map(function ($pago) {
                return [
                    'fecha' => $pago->fecha,
                    'concepto' => "Pago #{$pago->id} - {$pago->concepto}",
                    'tipo' => 'pago',
                    'monto' => $pago->monto,
                ];
            });

        $movs = $ventas->concat($pagos)->sortBy('fecha')->values();

        $saldo = 0;
        $movs = $movs->map(function ($mov) use (&$saldo) {
            $saldo += $mov['monto'];
            $mov['saldo'] = $saldo;
            return $mov;
        });

        $this->movimientos = $movs;
        $this->saldo = $saldo;
    }

    public function render()
    {
        return view('livewire.extracto.extracto-detalle');
    }
}
