<?php

namespace App\Livewire\Compra;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompraEdit extends Component
{
    public $compraId;

    public $codigo;
    public $proveedor_id;
    public $comprador_id;
    public $fecha_compra;
    public $total = 0;
    public $metodo_pago;
    public $fecha_llegada;
    public $estado;

    public $proveedores;
    public $productos;
    public $items = [];

    public function mount()
    {
        $this->proveedores = Proveedor::all();
        $this->productos = Producto::all();
    }

    #[On('compraEdit')]
    public function editCompra($id)
    {
        $compra = Compra::with('detalles')->findOrFail($id);

        $this->compraId = $compra->id;
        $this->codigo = $compra->codigo;
        $this->proveedor_id = $compra->proveedor_id;
        $this->comprador_id = $compra->comprador_id;
        $this->fecha_compra = $compra->fecha_compra;
        $this->total = $compra->total;
        $this->metodo_pago = $compra->metodo_pago;
        $this->fecha_llegada = $compra->fecha_llegada;
        $this->estado = $compra->estado;

        $this->items = $compra->detalles->map(function ($item) {
            return [
                'producto_id' => $item->producto_id,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
            ];
        })->toArray();

        Flux::modal('edit-compra')->show();
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

    public function updateCompra()
    {
        $this->validate([
            'codigo' => 'required|string|max:255',
            'proveedor_id' => 'required|exists:users,id',
            'fecha_compra' => 'required|date',
            'metodo_pago' => 'required|string',
            'estado' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () {
            $compra = Compra::findOrFail($this->compraId);

            $compra->update([
                'codigo' => $this->codigo,
                'proveedor_id' => $this->proveedor_id,
                'comprador_id' => $this->comprador_id,
                'fecha_compra' => $this->fecha_compra,
                'total' => $this->total,
                'metodo_pago' => $this->metodo_pago,
                'fecha_llegada' => $this->fecha_llegada,
                'estado' => $this->estado,
            ]);

            // Borrar detalles viejos
            $compra->detalles()->delete();

            // Insertar detalles nuevos
            foreach ($this->items as $item) {
                $compra->detalles()->create([
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['cantidad'] * $item['precio_unitario'],
                ]);
            }
        });

        Flux::modal('edit-compra')->close();
        session()->flash('success', 'Compra actualizada exitosamente.');
        $this->reset();
        $this->redirectRoute('compra.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.compra.compra-edit');
    }
}
