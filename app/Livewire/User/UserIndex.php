<?php

namespace App\Livewire\User;

use App\Models\User;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public $userId;

    public $search = '';
    public $filterId = '';
    public $filterName = '';
    public $filterEmail = '';
    public $filterRol = '';
    public $filterEstado = '';
    public $filterEmpresa = '';
    public $filterRazonSocial = '';
    public $filterNit = '';

    protected $updatesQueryString = [
        'search',
        'filterId',
        'filterName',
        'filterEmail',
        'filterRol',
        'filterEstado',
        'filterEmpresa',
        'filterRazonSocial',
        'filterNit',
    ];

    public function render()
    {
        $query = User::query();

        // Filtro global
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id', 'like', "%{$this->search}%")
                    ->orWhere('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('rol', 'like', "%{$this->search}%")
                    ->orWhere('estado', 'like', "%{$this->search}%")
                    ->orWhere('empresa', 'like', "%{$this->search}%")
                    ->orWhere('razon_social', 'like', "%{$this->search}%")
                    ->orWhere('nit', 'like', "%{$this->search}%");
            });
        }

        // Filtros por columna
        if ($this->filterId) {
            $query->where('id', 'like', "%{$this->filterId}%");
        }
        if ($this->filterName) {
            $query->where('name', 'like', "%{$this->filterName}%");
        }
        if ($this->filterName) {
            $query->where('name', 'like', "%{$this->filterName}%");
        }
        if ($this->filterEmail) {
            $query->where('email', 'like', "%{$this->filterEmail}%");
        }
        if ($this->filterRol) {
            $query->where('rol', 'like', "%{$this->filterRol}%");
        }
        if ($this->filterEstado) {
            $query->where('estado', 'like', "%{$this->filterEstado}%");
        }
        if ($this->filterEmpresa) {
            $query->where('empresa', 'like', "%{$this->filterEmpresa}%");
        }
        if ($this->filterRazonSocial) {
            $query->where('razon_social', 'like', "%{$this->filterRazonSocial}%");
        }
        if ($this->filterNit) {
            $query->where('nit', 'like', "%{$this->filterNit}%");
        }

        $usuarios = $query->orderBy('id', 'asc')->paginate(10);

        return view('livewire.user.user-index', [
            'usuarios' => $usuarios,
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('userEdit',  $id);
    }
    public function contacto($id)
    {
        $this->dispatch('contactos',  $id);
    }
    public function ubicacion($id)
    {
        $this->dispatch('userUbicacion',  $id);
    }
    public function delete($id)
    {
        $this->userId = $id;
        Flux::modal('delete-user')->show();
    }
    public function deleteUser()
    {
        try {
            $user = User::findOrFail($this->userId);
            $user->delete();
            Flux::modal('delete-user')->close();
            session()->flash('success', 'Usuario eliminado exitosamente.');
            $this->reset();
            $this->redirectRoute('user.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al eliminar el usuario: ' . $th->getMessage());
        }
    }
}
