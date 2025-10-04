<?php

namespace App\Livewire\Compra;

use App\Models\Compra;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class CompraIndex extends Component
{
    use WithPagination;

    public $compraId;

    public $search = '';
    public $filterCodigo = '';
    public $filterProveedor = '';
    public $filterFechaCompra = '';
    public $filterTotal = '';
    public $filterMetodoPago = '';
    public $filterEstado = '';

    public $expandedCompraId = null;



    protected $updatesQueryString = [
        'search',
        'filterCodigo',
        'filterProveedor',
        'filterFechaCompra',
        'filterTotal',
        'filterMetodoPago',
        'filterEstado'
    ];

    public function toggleDetalle($id)
    {
        $this->expandedCompraId = $this->expandedCompraId === $id ? null : $id;
    }

    public function render()
    {
        $query = Compra::with(['proveedor', 'comprador', 'detalles.producto']); // eager load relaciones

        //Filtro global
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('proveedor', 'like', "%{$this->search}%")
                    ->orWhere('fecha_compra', 'like', "%{$this->search}%")
                    ->orWhere('total', 'like', "%{$this->search}%")
                    ->orWhere('metodo_pago', 'like', "%{$this->search}%")
                    ->orWhere('estado', 'like', "%{$this->search}%");
            });
        }

        if ($this->filterCodigo) {
            $query->where('codigo', 'like', "%{$this->filterCodigo}%");
        }
        if ($this->filterProveedor) {
            $query->where('proveedor', 'like', "%{$this->filterProveedor}%");
        }
        if ($this->filterFechaCompra) {
            $query->where('fecha_compra', 'like', "%{$this->filterFechaCompra}%");
        }
        if ($this->filterTotal) {
            $query->where('total', 'like', "%{$this->filterTotal}%");
        }
        if ($this->filterMetodoPago) {
            $query->where('metodo_pago', 'like', "%{$this->filterMetodoPago}%");
        }
        if ($this->filterEstado) {
            $query->where('estado', 'like', "%{$this->filterEstado}%");
        }

        $compras = $query->orderBy('id', 'desc')->paginate(15);

    return view('livewire.compra.compra-index', compact('compras'));
    }

    public function edit($id)
    {
        $this->dispatch('compraEdit',  $id);
    }

    public function delete($id)
    {
        $this->compraId = $id;
        Flux::modal('delete-compra')->show();
    }

    public function deleteCompra()
    {
        try {
            $compra = Compra::findOrFail($this->compraId);
            $compra->delete();
            Flux::modal('delete-compra')->close();
            session()->flash('success', 'Compra eliminada exitosamente.');
            $this->reset();
            $this->redirectRoute('compra.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al eliminar la compra: ' . $th->getMessage());
        }
    }
}
