<?php

namespace App\Livewire\Proveedor;

use App\Models\Proveedor;
use Flux\Flux;
use Livewire\Component;

class ProveedorCreate extends Component
{
  //variables
    public $nombre;
    public $pais_origen;
    public $contacto_principal;
    public $telefono;
    public $email;

    //rules
    protected $rules = [
        'nombre' => 'required|string|max:255',
        'pais_origen' => 'required|string|max:255',
        'contacto_principal' => 'required|string|max:255',
        'telefono' => 'required|string|max:50',
        'email' => 'required|email|max:255|unique:users,email',
    ];

    public function createProveedor()
    {
        try {
            $this->validate();

            Proveedor::create([
                'nombre' => $this->nombre,
                'pais_origen' => $this->pais_origen,
                'contacto_principal' => $this->contacto_principal,
                'telefono' => $this->telefono,
                'email' => $this->email,
           
            ]);
            Flux::modal('default')->close('crear-proveedor');
            $this->reset();
            session()->flash('success', 'Proveedor creado exitosamente.');
            $this->redirectRoute('proveedor.index', navigate: true);
        } catch (\Throwable $th) {
            // Handle the exception, log it or show an error message
            session()->flash('error', 'Error al crear el proveedor: ' . $th->getMessage());
            Flux::modal('default')->close('crear-proveedor');
            $this->reset();
            $this->redirectRoute('proveedor.index', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.proveedor.proveedor-create');
    }
}
