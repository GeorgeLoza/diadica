<?php

namespace App\Livewire\Venta;

use App\Models\Venta;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class VentaIndex extends Component
{
     use WithPagination;

    public $ventaId;

    public $search = '';
    public $filterCodigo = '';
    public $filterCliente = '';
    public $filterFechaVenta = '';
    public $filterTotal = '';
    public $filterMetodoPago = '';
    public $filterEstado = '';

    public $expandedVentaId = null;



    protected $updatesQueryString = [
        'search',
        'filterCodigo',
        'filterCliente',
        'filterFechaVenta',
        'filterTotal',
        'filterMetodoPago',
        'filterEstado'
    ];

    public function toggleDetalle($id)
    {
        $this->expandedVentaId = $this->expandedVentaId === $id ? null : $id;
    }

    public function render()
    {
        $query = Venta::with(['cliente', 'vendedor', 'detalles.producto']); // eager load relaciones

        //Filtro global
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('cliente', 'like', "%{$this->search}%")
                    ->orWhere('fecha_venta', 'like', "%{$this->search}%")
                    ->orWhere('total', 'like', "%{$this->search}%")
                    ->orWhere('metodo_pago', 'like', "%{$this->search}%")
                    ->orWhere('estado', 'like', "%{$this->search}%");
            });
        }

        if ($this->filterCodigo) {
            $query->where('codigo', 'like', "%{$this->filterCodigo}%");
        }
        if ($this->filterCliente) {
            $query->where('cliente', 'like', "%{$this->filterCliente}%");
        }
        if ($this->filterFechaVenta) {
            $query->where('fecha_venta', 'like', "%{$this->filterFechaVenta}%");
        }
        if ($this->filterTotal) {
            $query->where('total', 'like', "%{$this->filterTotal}%");
        }
        if ($this->filterEstado) {
            $query->where('estado', 'like', "%{$this->filterEstado}%");
        }

        $ventas = $query->orderBy('id', 'desc')->paginate(15);

    return view('livewire.venta.venta-index', compact('ventas'));
    }

    public function edit($id)
    {
        $this->dispatch('ventaEdit',  $id);
    }

    public function delete($id)
    {
        $this->ventaId = $id;
        Flux::modal('delete-venta')->show();
    }

    public function deleteVenta()
    {
        try {
            $venta = Venta::findOrFail($this->ventaId);
            $venta->delete();
            Flux::modal('delete-venta')->close();
            session()->flash('success', 'Venta eliminada exitosamente.');
            $this->reset();
            $this->redirectRoute('venta.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al eliminar la venta: ' . $th->getMessage());
        }
    }
    
}
