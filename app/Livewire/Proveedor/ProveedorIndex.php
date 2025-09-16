<?php

namespace App\Livewire\Proveedor;

use App\Models\Proveedor;
use Flux\Flux;
use Livewire\Component;

class ProveedorIndex extends Component
{
     public $proveedorId;
    
    public $search = '';
    public $filterNombre = '';
    public $filterPaisOrigen = '';
    public $filterContactoPrincipal = '';
    public $filterTelefono = '';
    public $filterEmail = '';

     protected $updatesQueryString = [
        'search',
        'filterNombre',
        'filterPaisOrigen',
        'filterContactoPrincipal',
        'filterTelefono',
        'filterEmail'
    ];
    public function render()
    {
         $query = Proveedor::query();

        // Filtro global
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', "%{$this->search}%")
                    ->orWhere('pais_origen', 'like', "%{$this->search}%")
                    ->orWhere('contacto_principal', 'like', "%{$this->search}%")
                    ->orWhere('telefono', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

          // Filtros por columna
        if ($this->filterNombre) {
            $query->where('nombre', 'like', "%{$this->filterNombre}%");
        }
        if ($this->filterPaisOrigen) {
            $query->where('pais_origen', 'like', "%{$this->filterPaisOrigen}%");
        }
        if ($this->filterContactoPrincipal) {
            $query->where('contacto_principal', 'like', "%{$this->filterContactoPrincipal}%");
        }
        if ($this->filterTelefono) {
            $query->where('telefono', 'like', "%{$this->filterTelefono}%");
        }
        if ($this->filterEmail) {
            $query->where('email', 'like', "%{$this->filterEmail}%");
        }

        $proveedores = $query->orderBy('id', 'asc')->paginate(10);

        return view('livewire.proveedor.proveedor-index', compact('proveedores'));
    }
    public function edit($id)
    {
        $this->dispatch('proveedorEdit',  $id);
    }
    public function delete($id)
    {
        $this->proveedorId = $id;
        Flux::modal('delete-proveedor')->show();
    }
    public function deleteProveedor()
    {
        try {
            $proveedor = Proveedor::findOrFail($this->proveedorId);
            $proveedor->delete();
            Flux::modal('delete-proveedor')->close();
            session()->flash('success', 'Proveedor eliminado exitosamente.');
            $this->reset();
            $this->redirectRoute('proveedor.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al eliminar el proveedor: ' . $th->getMessage());
        }
    }
}
