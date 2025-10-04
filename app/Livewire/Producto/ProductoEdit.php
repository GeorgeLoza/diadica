<?php

namespace App\Livewire\Producto;

use App\Models\Bobina;
use App\Models\Producto;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductoEdit extends Component
{
    public $productoId;
    public $nombre;
    public $descripcion;
    public $unidad_medida;
    public $categoria;
    
    #[On('productoEdit')]
    public function editProducto($id)
    {
        $producto = Producto::findOrFail($id);
        $this->productoId = $producto->id;
        $this->nombre = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->unidad_medida = $producto->unidad_medida;
        $this->categoria = $producto->categoria;
        Flux::modal('edit-producto')->show();
    }

    public function updateProducto()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'unidad_medida' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
        ]);

        try {
            $producto = Producto::findOrFail($this->productoId);
            $producto->nombre = $this->nombre;
            $producto->descripcion = $this->descripcion;
            $producto->unidad_medida = $this->unidad_medida;
            $producto->categoria = $this->categoria;
            $producto->save();

            Flux::modal('edit-producto')->close();
            session()->flash('success', 'Producto actualizado exitosamente.');
            $this->reset();
            $this->redirectRoute('producto.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al actualizar el producto: ' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.producto.producto-edit');
    }
}
