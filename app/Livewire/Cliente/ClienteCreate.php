<?php

namespace App\Livewire\Cliente;

use App\Models\Cliente;
use Flux\Flux;
use Livewire\Component;

class ClienteCreate extends Component
{
     //variables
    public $nombre_empresa;
    public $nombre_cliente;
    public $nit_ci;
    public $telefono;
    public $direccion;
    public $credito;
    public $saldo;
    public $estado;
    



    //rules
    protected $rules = [
        'nombre_empresa' => 'required|string|max:255',
        'nombre_cliente' => 'required|string|max:255',
        'nit_ci' => 'required|string|max:50|unique:clientes,nit_ci',
        'telefono' => 'required|string|max:20',
        'direccion' => 'nullable|string|max:255',
        'credito' => 'nullable|numeric|min:0',
        'saldo' => 'nullable|numeric|min:0',
        'estado' => 'required|string|max:50',
    ];
    public function createCliente()
    {
        try {
            $this->validate();

            Cliente::create([
                'nombre_empresa' => $this->nombre_empresa,
                'nombre_cliente' => $this->nombre_cliente,
                'nit_ci' => $this->nit_ci,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
                'credito' => $this->credito ?? 0,
                'saldo' => $this->saldo ?? 0,
                'fecha_registro' => now(),
                'estado' => $this->estado,  
            ]);

            Flux::modal('default')->close('crear-cliente');
            $this->reset();
            session()->flash('success', 'Cliente creado exitosamente.');
            $this->redirectRoute('cliente.index', navigate: true);
        } catch (\Throwable $th) {
            // Handle the exception, log it or show an error message
            session()->flash('error', 'Error al crear el cliente: ' . $th->getMessage());
            Flux::modal('default')->close('crear-cliente');
            $this->reset();
            $this->redirectRoute('cliente.index', navigate: true);
        }
    }
    public function render()
    {
        return view('livewire.cliente.cliente-create');
    }
}
