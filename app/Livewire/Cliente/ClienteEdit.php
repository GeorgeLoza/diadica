<?php

namespace App\Livewire\Cliente;

use App\Models\Cliente;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class ClienteEdit extends Component
{
    public $clienteId;
     public $nombre_empresa;
    public $nombre_cliente;
    public $nit_ci;
    public $telefono;
    public $direccion;
    public $credito;
    public $saldo;
    public $estado;

    #[On('clienteEdit')]
    public function editCliente($id)
    {
        $cliente = Cliente::findOrFail($id);
        $this->clienteId = $cliente->id;
        $this->nombre_empresa = $cliente->nombre_empresa;
        $this->nombre_cliente = $cliente->nombre_cliente;
        $this->nit_ci = $cliente->nit_ci;
        $this->telefono = $cliente->telefono;
        $this->direccion = $cliente->direccion;
        $this->credito = $cliente->credito;
        $this->saldo = $cliente->saldo;
        $this->estado = $cliente->estado;
        Flux::modal('edit-cliente')->show();
    }

    
    public function updateCliente()
    {
        $this->validate([
            'nombre_empresa' => 'required|string|max:255',
            'nombre_cliente' => 'required|string|max:255',
            'nit_ci' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'credito' => 'required|numeric',
            'saldo' => 'required|numeric',
            'estado' => 'required|string|max:50',
        ]);

        try {
            $cliente = Cliente::findOrFail($this->clienteId);
            $cliente->nombre_empresa = $this->nombre_empresa;
            $cliente->nombre_cliente = $this->nombre_cliente;
            $cliente->nit_ci = $this->nit_ci;
            $cliente->telefono = $this->telefono;
            $cliente->direccion = $this->direccion;
            $cliente->credito = $this->credito;
            $cliente->saldo = $this->saldo;
            $cliente->estado = $this->estado;
            $cliente->save();

            Flux::modal('edit-cliente')->close();
            session()->flash('success', 'Cliente actualizado exitosamente.');
            $this->reset();
            $this->redirectRoute('cliente.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al actualizar el cliente: ' . $th->getMessage());
        }
    }


       
    public function render()
    {
        return view('livewire.cliente.cliente-edit');
    }
}
