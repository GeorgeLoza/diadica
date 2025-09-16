<?php

namespace App\Livewire\Bobina;

use App\Models\Bobina;
use App\Models\Producto;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class BobinaEdit extends Component
{
    public $bobinaId;
    public $id_producto;
    public $peso;
    public $lote;
    public $fecha_ingreso;
    public $estado;
    public $costo_unitario;
    #[On('bobinaEdit')]
    public function editbobina($id)
    {
        $bobinaId = Bobina::findOrFail($id);
        $this->bobinaId = $bobinaId->id;
        $this->id_producto = $bobinaId->id_producto;
        $this->peso = $bobinaId->peso;
        $this->lote = $bobinaId->lote;
        $this->fecha_ingreso = $bobinaId->fecha_ingreso;
        $this->estado = $bobinaId->estado;
        $this->costo_unitario = $bobinaId->costo_unitario;
        Flux::modal('edit-bobina')->show();
    }

    public function updateBobina()
    {
        $this->validate([
            'id_producto' => 'required|string|max:255',
            'peso' => 'required|string|max:255',
            'lote' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|string|max:50',
            'costo_unitario' => 'required|numeric',
        ]);

        try {
            $bobina = Bobina::findOrFail($this->bobinaId);
            $bobina->id_producto = $this->id_producto;
            $bobina->peso = $this->peso;
            $bobina->lote = $this->lote;
            $bobina->fecha_ingreso = $this->fecha_ingreso;
            $bobina->estado = $this->estado;
            $bobina->costo_unitario = $this->costo_unitario;
            $bobina->save();

            Flux::modal('edit-bobina')->close();
            session()->flash('success', 'Bobina actualizada exitosamente.');
            $this->reset();
            $this->redirectRoute('bobina.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al actualizar la bobina: ' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.bobina.bobina-edit');
    }
}
