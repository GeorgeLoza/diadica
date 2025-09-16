<?php

namespace App\Livewire\Producto;

use App\Models\Producto;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class ProductoIndex extends Component
{
    use WithPagination;

    public $productoId;

    public $search = '';
    public $filterCodigo = '';
    public $filterNombre = '';
    public $filterDescripcion = '';
    public $filterUnidadMedida = '';
    public $filterCategoria = '';

    protected $updatesQueryString = [
        'search',
        'filterCodigo',
        'filterNombre',
        'filterDescripcion',
        'filterUnidadMedida',
        'filterCategoria'
    ];




    public function render()
    {
        $query = Producto::query();

        //Filtro global
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('nombre', 'like', "%{$this->search}%")
                    ->orWhere('descripcion', 'like', "%{$this->search}%")
                    ->orWhere('unidad_medida', 'like', "%{$this->search}%")
                    ->orWhere('categoria', 'like', "%{$this->search}%");
            });
        }

        if ($this->filterCodigo) {
            $query->where('codigo', 'like', "%{$this->filterCodigo}%");
        }
        if ($this->filterNombre) {
            $query->where('nombre', 'like', "%{$this->filterNombre}%");
        }
        if ($this->filterDescripcion) {
            $query->where('descripcion', 'like', "%{$this->filterDescripcion}%");
        }
        if ($this->filterUnidadMedida) {
            $query->where('unidad_medida', 'like', "%{$this->filterUnidadMedida}%");
        }
        if ($this->filterCategoria) {
            $query->where('categoria', 'like', "%{$this->filterCategoria}%");
        }

        $productos = $query->orderBy('id', 'desc')->paginate(15);

        return view('livewire.producto.producto-index', compact('productos'));
    }

    public function edit($id)
    {
        $this->dispatch('productoEdit',  $id);
    }
    public function delete($id)
    {
        $this->productoId = $id;
        Flux::modal('delete-producto')->show();
    }
    public function deleteProduct()
    {
        try {
            $producto = Producto::findOrFail($this->productoId);
            $producto->delete();
            Flux::modal('delete-producto')->close();
            session()->flash('success', 'Producto eliminado exitosamente.');
            $this->reset();
            $this->redirectRoute('producto.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al eliminar el producto: ' . $th->getMessage());
        }
    }
}
