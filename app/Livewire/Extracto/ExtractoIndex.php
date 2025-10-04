<?php

namespace App\Livewire\Extracto;

use App\Models\Pago;
use App\Models\User;
use App\Models\Venta;
use Livewire\Component;

class ExtractoIndex extends Component
{
    public $clientes = [];
    public $saldos = [];

    public function mount()
    {
        // cargamos clientes filtrando por la columna 'rol' (no relación)
        $this->clientes = User::where('rol', 'cliente')->get();

        $this->calcularSaldos();
    }

    public function calcularSaldos()
    {
        $this->saldos = [];

        foreach ($this->clientes as $cliente) {
            $ventas = Venta::where('cliente_id', $cliente->id)->sum('total');
            $pagos = Pago::where('cliente_id', $cliente->id)->sum('monto');

            // saldo = pagos - ventas  (positivo = a favor del cliente, negativo = deuda)
            $saldo = $pagos - $ventas;

            $this->saldos[$cliente->id] = $saldo;
        }
    }

    // cuando el usuario hace click en "Ver extracto"
       public function verDetalle($clienteId)
    {
        return redirect()->route('extracto.detalle', $clienteId);
    }

    public function render()
    {
        return view('livewire.extracto.extracto-index');
    }
}
