<?php

namespace App\Livewire\Venta;

use App\Models\User;
use App\Models\Venta;
use Flux\Flux;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VentaCreate extends Component
{
     //varibles
    public $codigo;
    public $cliente_id;
    public $fecha_venta;
    public $total;
    public $estado;

    public $items = [
        ['producto_id' => '', 'cantidad' => 1, 'precio_unitario' => 0]
    ];


    public $clientes;


    protected $rules = [
        'cliente_id' => 'required|exists:users,id',
        'fecha_venta' => 'required|date',
        'estado' => 'required|string|max:50',
        'items.*.producto_id' => 'required|exists:productos,id',
        'items.*.cantidad' => 'required|integer|min:1',
        'items.*.precio_unitario' => 'required|numeric|min:0',
    ];
    public function mount()
    {
        $this->clientes = User::where('rol', 'cliente')->get();
        $this->estado = 'pendiente';
        $this->codigo = $this->generarCodigo();
    }


    public function addItem()
    {
        $this->items[] = ['producto_id' => '', 'cantidad' => 1, 'precio_unitario' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindexar
    }

    public function crearVenta()
    {
        $this->validate();
        $this->calcularTotal();

        DB::beginTransaction();
        try {
            $venta = Venta::create([
                'codigo' => $this->codigo,
                'cliente_id' => $this->cliente_id,
                'vendedor_id' => auth()->id(),
                'fecha_venta' => $this->fecha_venta,
                'total' => $this->total,
                'estado' => $this->estado,
            ]);

            foreach ($this->items as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario'];
                $venta->detalles()->create([
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();
            Flux::modal('default')->close('crear-venta');
            $this->reset();
            session()->flash('success', 'Venta creada exitosamente.');
            $this->redirectRoute('venta.index', navigate: true);
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Error al crear la venta: ' . $th->getMessage());
            Flux::modal('default')->close('crear-venta');
            $this->reset();
            $this->redirectRoute('venta.index', navigate: true);
        }
    }
    private function generarCodigo()
    {
        $ultimo = Venta::latest('id')->first();
        if (!$ultimo) {
            return 10001;
        }
        return $ultimo->codigo + 1;
    }
    public function updatedItems()
    {
        $this->calcularTotal();
    }

    private function calcularTotal()
    {
        $this->total = collect($this->items)->sum(function ($item) {
            return $item['cantidad'] * $item['precio_unitario'];
        });
    }

    public function render()
    {
        return view('livewire.venta.venta-create', [
            'productos' => \App\Models\Producto::all(),
        ]);
    }
}
