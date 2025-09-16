<?php

namespace App\Livewire\Producto;

use App\Models\Producto;
use Flux\Flux;
use Livewire\Component;

class ProductoCreate extends Component
{
    //varibles
    public $codigo;
    public $nombre;
    public $descripcion;
    public $unidad_medida;
    public $categoria;

    protected $rules = [
        'codigo' => 'required|unique:productos,codigo',
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'unidad_medida' => 'nullable|string|max:15',
        'categoria' => 'nullable|string|max:50',
    ];

    public function createProduct()
    {
        try {
            $this->validate();

            // Crear el producto en la base de datos
            Producto::create([
                'codigo' => $this->codigo,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'unidad_medida' => $this->unidad_medida,
                'categoria' => $this->categoria,
            ]);
            Flux::modal('default')->close('crear-producto');
            $this->reset();
            session()->flash('success', 'Producto creado exitosamente.');
            $this->redirectRoute('producto.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al crear el producto: ' . $th->getMessage());
            Flux::modal('default')->close('crear-producto');
            $this->reset();
            $this->redirectRoute('producto.index', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.producto.producto-create');
    }
}
