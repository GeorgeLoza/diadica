<?php

namespace App\Livewire\Pago;

use App\Models\Pago;
use App\Models\User;
use Flux\Flux;
use Livewire\Component;

class PagoCreate extends Component
{
    public $lugar_pago;
    public $recibi_de;
    public $tipo_pago;
    public $concepto;
    public $comprobante;
    public $monto;
    public $moneda = 'bs';
    public $tipo_cambio = 1;
    public $total;
    public $trabajador_id;
    public $cliente_id;

    public $clientes;
    public $trabajadores;

    protected $rules = [
        'lugar_pago' => 'required|string|max:255',
        'recibi_de' => 'required|string|max:255',
        'tipo_pago' => 'required|string|max:255',
        'concepto' => 'required|string|max:255',
        'comprobante' => 'required|string|max:255',
        'monto' => 'required|numeric',
        'moneda' => 'required|in:bs,dolar,euro',
        'tipo_cambio' => 'required|numeric|min:0.0001',
        'cliente_id' => 'required|exists:users,id',
    ];

    public function mount()
    {
        $this->clientes = User::where('rol', 'cliente')->get();
        $this->trabajadores = User::where('rol', 'trabajador')->get();
        $this->moneda = 'bs';
        $this->tipo_cambio = 1;
        $this->total = 0;
    }

    public function updatedMonto()
    {
        $this->calcularTotal();
    }

    public function updatedTipoCambio()
    {
        $this->calcularTotal();
    }

    public function updatedMoneda()
    {
        // Puedes poner aquí lógica para sugerir un tipo de cambio por defecto según la moneda
        if ($this->moneda === 'bs') {
            $this->tipo_cambio = 1;
        }
        $this->calcularTotal();
    }

    public function calcularTotal()
    {
        $this->total = $this->monto && $this->tipo_cambio ? $this->monto * $this->tipo_cambio : 0;
    }

    public function createPago()
    {
        $this->calcularTotal();
        try {
            $this->validate();

            Pago::create([
                'codigo' => Pago::max('codigo') + 1 ?? 1,
                'lugar_pago' => $this->lugar_pago,
                'recibi_de' => $this->recibi_de,
                'tiempo' => now(),
                'tipo_pago' => $this->tipo_pago,
                'concepto' => $this->concepto,
                'comprobante' => $this->comprobante,
                'monto' => $this->monto,
                'moneda' => $this->moneda,
                'total' => $this->total,
                'estado' => "Completado",
                'trabajador_id' => auth()->id(),
                'cliente_id' => $this->cliente_id,
                'tipo_cambio' => $this->tipo_cambio,
            ]);
            Flux::modal('default')->close('crear-pago');
            $this->reset();
            session()->flash('success', 'Pago creado exitosamente.');
            $this->redirectRoute('pago.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al crear el pago: ' . $th->getMessage());
            Flux::modal('default')->close('crear-pago');
            $this->reset();
            $this->redirectRoute('pago.index', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.pago.pago-create');
    }
}
