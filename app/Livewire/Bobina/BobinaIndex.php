<?php

namespace App\Livewire\Bobina;

use App\Models\Bobina;
use Flux\Flux;
use Livewire\Component;

class BobinaIndex extends Component
{
     public $bobinaId;

    public $search = '';
    public $filterid_bobina = '';
    public $filterid_producto = '';
    public $filterPeso = '';
    public $filterLote = '';
    public $filterFechaIngreso = '';
    public $filterEstado = '';
    public $filtercosto_unitario = '';

    protected $updatesQueryString = [
        'search',
        'filterid_bobina',
        'filterid_producto',
        'filterPeso',
        'filterLote',
        'filterFechaIngreso',
        'filterEstado',
        'filtercosto_unitario'
    ];
    public function render()
    {
        $query = Bobina::query();

        //Filtro global
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id_bobina', 'like', "%{$this->search}%")
                    ->orWhere('id_producto', 'like', "%{$this->search}%")
                    ->orWhere('peso', 'like', "%{$this->search}%")
                    ->orWhere('lote', 'like', "%{$this->search}%")
                    ->orWhere('fecha_ingreso', 'like', "%{$this->search}%")
                    ->orWhere('estado', 'like', "%{$this->search}%")
                    ->orWhere('costo_unitario', 'like', "%{$this->search}%");
            });
        }
         if ($this->filterid_bobina) {
            $query->where('id_bobina', 'like', "%{$this->filterid_bobina}%");
        }
        if ($this->filterid_producto) {
            $query->where('id_producto', 'like', "%{$this->filterid_producto}%");
        }
        if ($this->filterPeso) {
            $query->where('peso', 'like', "%{$this->filterPeso}%");
        }
        if ($this->filterLote) {
            $query->where('lote', 'like', "%{$this->filterLote}%");
        }
        if ($this->filterFechaIngreso) {
            $query->where('fecha_ingreso', 'like', "%{$this->filterFechaIngreso}%");
        }
        if ($this->filterEstado) {
            $query->where('estado', 'like', "%{$this->filterEstado}%");
        }
        if ($this->filtercosto_unitario) {
            $query->where('costo_unitario', 'like', "%{$this->filtercosto_unitario}%");
        }

        $bobinas = $query->orderBy('id', 'desc')->paginate(15);
        return view('livewire.bobina.bobina-index', compact('bobinas'));

    }

    public function edit($id)
    {
        $this->dispatch('bobinaEdit',  $id);
    }
    public function delete($id)
    {
        $this->bobinaId = $id;
        Flux::modal('delete-bobina')->show();
    }
    public function deleteBobina()
    {
        try {
            $bobina = Bobina::findOrFail($this->bobinaId);
            $bobina->delete();
            Flux::modal('delete-bobina')->close();
            session()->flash('success', 'Bobina eliminada exitosamente.');
            $this->reset();
            $this->redirectRoute('bobina.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al eliminar la bobina: ' . $th->getMessage());
        }
    }
}   