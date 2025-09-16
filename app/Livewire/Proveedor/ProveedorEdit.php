<?php

namespace App\Livewire\Proveedor;

use App\Models\Proveedor;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class ProveedorEdit extends Component
{
    public $proveedorId;
    public $nombre;
    public $pais_origen;
    public $contacto_principal;
    public $telefono;
    public $email;
    #[On('proveedorEdit')]
    public function editProveedor($id)
    {
        $proveedor = Proveedor::find($id);
        if ($proveedor) {
            $this->proveedorId = $proveedor->id;
            $this->nombre = $proveedor->nombre;
            $this->pais_origen = $proveedor->pais_origen;
            $this->contacto_principal = $proveedor->contacto_principal;
            $this->telefono = $proveedor->telefono;
            $this->email = $proveedor->email;
            Flux::modal('edit-proveedor')->show();
        }
    }
    
     public function updateProveedor()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'pais_origen' => 'required|string|max:255',
            'contacto_principal' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'email' => 'required|string|email|max:255',
        ]);

        try {
            $proveedor = Proveedor::findOrFail($this->proveedorId);
            $proveedor->nombre = $this->nombre;
            $proveedor->pais_origen = $this->pais_origen;
            $proveedor->contacto_principal = $this->contacto_principal;
            $proveedor->telefono = $this->telefono;
            $proveedor->email = $this->email;
            $proveedor->save();

            Flux::modal('edit-proveedor')->close();
            session()->flash('success', 'Proveedor actualizado exitosamente.');
            $this->reset();
            $this->redirectRoute('proveedor.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al actualizar el proveedor: ' . $th->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.proveedor.proveedor-edit');
    }
}
