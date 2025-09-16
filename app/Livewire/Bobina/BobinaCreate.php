<?php

namespace App\Livewire\Bobina;

use App\Models\Bobina;
use Flux\Flux;
use Livewire\Component;

class BobinaCreate extends Component
{
    public $id_bobina;
    public $id_producto;
    public $peso;
    public $lote;
    public $estado;
    public $costo_unitario;
    public $fecha_ingreso;

    protected $rules = [
        'id_bobina' => 'required|unique:bobinas,id_bobina',
        'id_producto' => 'required|exists:productos,id',
        'peso' => 'required|numeric',
        'lote' => 'required|string|max:255',
        'estado' => 'nullable|string|max:50',
        'costo_unitario' => 'nullable|numeric',
        'fecha_ingreso' => 'nullable|date',
    ];
     public function createbobina()
    {
        try {
            $this->validate();

            // Crear la bobina en la base de datos
            Bobina::create([
                'id_bobina' => $this->id_bobina,
                'id_producto' => $this->id_producto,
                'peso' => $this->peso,
                'lote' => $this->lote,
                'estado' => $this->estado,
                'costo_unitario' => $this->costo_unitario,
                'fecha_ingreso' => $this->fecha_ingreso,
            ]);
            Flux::modal('default')->close('crear-bobina');
            $this->reset();
            session()->flash('success', 'Bobina creada exitosamente.');
            $this->redirectRoute('bobina.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al crear la bobina: ' . $th->getMessage());
            Flux::modal('default')->close('crear-bobina');
            $this->reset();
            $this->redirectRoute('bobina.index', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.bobina.bobina-create');
    }
}
