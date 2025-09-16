<?php

namespace App\Livewire\Cliente;

use App\Models\Cliente;
use Flux\Flux;
use Livewire\Component;


class ClienteIndex extends Component
{
    //variables de id del cliente para editar y eliminar
    public $clienteId;
    //variables de busqueda y filtro
    public $search = '';
    public $filterNombreEmpresa = '';
    public $filterNombreContacto = '';
    public $filterNitCi = '';
    public $filterTelefono = '';
    public $filterEstado = '';

    protected $updatesQueryString = [
        'search',
        'filterNombreEmpresa',
        'filterNombreContacto',
        'filterNitCi',
        'filterTelefono',
        'filterEstado'
    ];

    public function render()
    {
         $query = Cliente::query();

        // Filtro global
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre_empresa', 'like', "%{$this->search}%")
                    ->orWhere('nombre_cliente', 'like', "%{$this->search}%")
                    ->orWhere('nit_ci', 'like', "%{$this->search}%")
                    ->orWhere('telefono', 'like', "%{$this->search}%")
                    ->orWhere('estado', 'like', "%{$this->search}%");
            });
        }

        // Filtros por columna
        if ($this->filterNombreEmpresa) {
            $query->where('nombre_empresa', 'like', "%{$this->filterNombreEmpresa}%");
        }
        if ($this->filterNombreContacto) {
            $query->where('nombre_contacto', 'like', "%{$this->filterNombreContacto}%");
        }
        if ($this->filterNitCi) {
            $query->where('nit_ci', 'like', "%{$this->filterNitCi}%");
        }
        if ($this->filterTelefono) {
            $query->where('telefono', 'like', "%{$this->filterTelefono}%");
        }
        if ($this->filterEstado) {
            $query->where('estado', 'like', "%{$this->filterEstado}%");
        }

        $clientes = $query->orderBy('id', 'asc')->paginate(10);

        return view('livewire.cliente.cliente-index', compact('clientes'));
    }
     public function edit($id)
    {
        $this->dispatch('clienteEdit',  $id);
    }
    public function delete($id)
    {
        $this->clienteId = $id;
        Flux::modal('delete-cliente')->show();
    }
    public function deleteCliente()
    {
        try {
            $cliente = Cliente::findOrFail($this->clienteId);
            $cliente->delete();
            Flux::modal('delete-cliente')->close();
            session()->flash('success', 'Cliente eliminado exitosamente.');
            $this->reset();
            $this->redirectRoute('cliente.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al eliminar el cliente: ' . $th->getMessage());
        }
    }
}
