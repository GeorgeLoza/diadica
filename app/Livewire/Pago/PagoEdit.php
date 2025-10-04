<?php

namespace App\Livewire\Pago;

use App\Models\Pago;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class PagoEdit extends Component
{
    public $pagoId;

    public $codigo;
    public $lugar_pago;
    public $recibi_de;
    public $tipo_pago;
    public $concepto;
    public $comprobante;
    public $monto;
    public $moneda;
    public $total;
    public $estado;
    public $trabajador_id;
    public $cliente_id;

    public $clientes;
    public $trabajadores;

    public function mount()
    {
        $this->clientes = \App\Models\User::where('rol', 'cliente')->get();
        $this->trabajadores = \App\Models\User::where('rol', 'trabajador')->get();
    }
    #[On('pagoEdit')]
    public function editPago($id)
    {
        $pago = Pago::findOrFail($id);
        $this->pagoId = $pago->id;
        $this->codigo = $pago->codigo;
        $this->lugar_pago = $pago->lugar_pago;
        $this->recibi_de = $pago->recibi_de;
        $this->tipo_pago = $pago->tipo_pago;
        $this->concepto = $pago->concepto;
        $this->comprobante = $pago->comprobante;
        $this->monto = $pago->monto;
        $this->moneda = $pago->moneda;
        $this->total = $pago->total;
        $this->estado = $pago->estado;
        $this->trabajador_id = $pago->trabajador_id;
        $this->cliente_id = $pago->cliente_id;
        Flux::modal('edit-pago')->show();
    }

    public function updatePago()
    {
        $this->validate([
            'codigo' => 'required|string|max:255',
            'lugar_pago' => 'required|string|max:255',
            'recibi_de' => 'required|string|max:255',
            'tipo_pago' => 'required|string|max:255',
            'concepto' => 'required|string|max:255',
            'comprobante' => 'required|string|max:255',
            'monto' => 'required|numeric',
            'moneda' => 'required|string|max:255',
            'total' => 'required|numeric',
            'estado' => 'required|string|max:255',
            'trabajador_id' => 'required|exists:users,id',
            'cliente_id' => 'required|exists:users,id',
        ]);

        try {
            $pago = Pago::findOrFail($this->pagoId);
            
            $pago->codigo = $this->codigo;
            $pago->lugar_pago = $this->lugar_pago;
            $pago->recibi_de = $this->recibi_de;
            $pago->tipo_pago = $this->tipo_pago;
            $pago->concepto = $this->concepto;
            $pago->comprobante = $this->comprobante;
            $pago->monto = $this->monto;
            $pago->moneda = $this->moneda;
            $pago->total = $this->total;
            $pago->estado = $this->estado;
            $pago->trabajador_id = $this->trabajador_id;
            $pago->cliente_id = $this->cliente_id;
            $pago->save();

            Flux::modal('edit-pago')->close();
            session()->flash('success', 'Pago actualizado exitosamente.');
            $this->reset();
            $this->redirectRoute('pago.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al actualizar el pago: ' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pago.pago-edit');
    }
}
