<?php

namespace App\Livewire\Venta;

use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VentaEdit extends Component
{
      public $ventaId;

    public $codigo;
    public $cliente_id;
    public $vendedor_id;
    public $fecha_venta;
    public $total = 0;
    public $estado;

    public $clientes;
    public $productos;
    public $items = [];

    public function mount()
    {
        $this->clientes = User::where('rol', 'cliente')->get();
        $this->productos = Producto::all();
    }

    #[On('ventaEdit')]
    public function editVenta($id)
    {
        $venta = Venta::with('detalles')->findOrFail($id);

        $this->ventaId = $venta->id;
        $this->codigo = $venta->codigo;
        $this->cliente_id = $venta->cliente_id;
        $this->vendedor_id = $venta->vendedor_id;
        $this->fecha_venta = $venta->fecha_venta;
        $this->total = $venta->total;
        $this->estado = $venta->estado;

        $this->items = $venta->detalles->map(function ($item) {
            return [
                'producto_id' => $item->producto_id,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
            ];
        })->toArray();

        Flux::modal('edit-venta')->show();
    }

    public function addItem()
    {
        $this->items[] = [
            'producto_id' => null,
            'cantidad' => 1,
            'precio_unitario' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->recalculateTotal();
    }

    public function recalculateTotal()
    {
        $this->total = collect($this->items)->sum(function ($item) {
            return ($item['cantidad'] ?? 0) * ($item['precio_unitario'] ?? 0);
        });
    }

    public function updatedItems()
    {
        $this->recalculateTotal();
    }

    public function updateVenta()
    {
        $this->validate([
            'codigo' => 'required|string|max:255',
            'cliente_id' => 'required|exists:users,id',
            'fecha_venta' => 'required|date',
            'estado' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () {
            $venta = Venta::findOrFail($this->ventaId);

            $venta->update([
                'codigo' => $this->codigo,
                'cliente_id' => $this->cliente_id,
                'vendedor_id' => $this->vendedor_id,
                'fecha_venta' => $this->fecha_venta,
                'total' => $this->total,
                'estado' => $this->estado,
            ]);

            // Borrar detalles viejos
            $venta->detalles()->delete();

            // Insertar detalles nuevos
            foreach ($this->items as $item) {
                $venta->detalles()->create([
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['cantidad'] * $item['precio_unitario'],
                ]);
            }
        });

        Flux::modal('edit-venta')->close();
        session()->flash('success', 'Venta actualizada exitosamente.');
        $this->reset();
        $this->redirectRoute('venta.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.venta.venta-edit');
    }
}
