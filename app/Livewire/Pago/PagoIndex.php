<?php

namespace App\Livewire\Pago;

use App\Models\Pago;
use Flux\Flux;
use Livewire\WithPagination;

use Livewire\Component;

class PagoIndex extends Component
{
    use WithPagination;

    public $pagoId;

    public $search = '';
    public $filterCodigo = '';
    public $filterLugarPago = '';
    public $filterRecibiDe = '';
    public $filterTiempo = '';
    public $filterTipoPago = '';
    public $filterConcepto = '';
    public $filterComprobante = '';
    public $filterMonto = '';
    public $filterMoneda = '';
    public $filterTotal = '';
    public $filterEstado = '';
    public $filterTrabajador = '';
    public $filterCliente = '';

    public function render()
    {
        $query = Pago::query();
        //Filtro global
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('lugar_pago', 'like', "%{$this->search}%")
                    ->orWhere('recibi_de', 'like', "%{$this->search}%")
                    ->orWhere('tiempo', 'like', "%{$this->search}%")
                    ->orWhere('tipo_pago', 'like', "%{$this->search}%")
                    ->orWhere('concepto', 'like', "%{$this->search}%")
                    ->orWhere('comprobante', 'like', "%{$this->search}%")
                    ->orWhere('monto', 'like', "%{$this->search}%")
                    ->orWhere('moneda', 'like', "%{$this->search}%")
                    ->orWhere('total', 'like', "%{$this->search}%")
                    ->orWhere('estado', 'like', "%{$this->search}%")
                    ->orWhereHas('trabajador', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('cliente', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    });
            });
        }
        if ($this->filterCodigo) {
            $query->where('codigo', 'like', "%{$this->filterCodigo}%");
        }
        if ($this->filterLugarPago) {
            $query->where('lugar_pago', 'like', "%{$this->filterLugarPago}%");
        }
        if ($this->filterRecibiDe) {
            $query->where('recibi_de', 'like', "%{$this->filterRecibiDe}%");
        }
        if ($this->filterTiempo) {
            $query->where('tiempo', 'like', "%{$this->filterTiempo}%");
        }
        if ($this->filterTipoPago) {
            $query->where('tipo_pago', 'like', "%{$this->filterTipoPago}%");
        }
        if ($this->filterConcepto) {
            $query->where('concepto', 'like', "%{$this->filterConcepto}%");
        }
        if ($this->filterComprobante) {
            $query->where('comprobante', 'like', "%{$this->filterComprobante}%");
        }
        if ($this->filterMonto) {
            $query->where('monto', 'like', "%{$this->filterMonto}%");
        }
        if ($this->filterMoneda) {
            $query->where('moneda', 'like', "%{$this->filterMoneda}%");
        }
        if ($this->filterTotal) {
            $query->where('total', 'like', "%{$this->filterTotal}%");
        }
        if ($this->filterEstado) {
            $query->where('estado', 'like', "%{$this->filterEstado}%");
        }
        if ($this->filterTrabajador) {
            $query->whereHas('trabajador', function ($q) {
                $q->where('name', 'like', "%{$this->filterTrabajador}%");
            });
        }
        if ($this->filterCliente) {
            $query->whereHas('cliente', function ($q) {
                $q->where('name', 'like', "%{$this->filterCliente}%");
            });
        }
        $pagos = $query->orderBy('id', 'desc')->paginate(10);
        return view('livewire.pago.pago-index', compact('pagos'));
    }

     public function edit($id)
    {
        $this->dispatch('pagoEdit',  $id);
    }
    public function delete($id)
    {
        $this->pagoId = $id;
        Flux::modal('delete-pago')->show();
    }
    public function deletePago()
    {
        try {
            $pago = Pago::findOrFail($this->pagoId);
            $pago->delete();
            Flux::modal('delete-pago')->close();
            session()->flash('success', 'Pago eliminado exitosamente.');
            $this->reset();
            $this->redirectRoute('pago.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al eliminar el pago: ' . $th->getMessage());
        }
    }

}
