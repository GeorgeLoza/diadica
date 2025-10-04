<?php

namespace App\Livewire\Compra;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\User;
use Flux\Flux;
use Livewire\Component;
// para usar el /db
use Illuminate\Support\Facades\DB;

class CompraCreate extends Component
{
    //varibles
    public $codigo;
    public $proveedor_id;
    public $comprador;
    public $fecha_compra;
    public $total;
    public $metodo_pago;
    public $fecha_llegada;
    public $estado;

    public $items = [
        ['producto_id' => '', 'cantidad' => 1, 'precio_unitario' => 0]
    ];


    public $proveedores;


    protected $rules = [
        'proveedor_id' => 'required|exists:proveedors,id',
        'fecha_compra' => 'required|date',
        'metodo_pago' => 'required|string|max:50',
        'fecha_llegada' => 'required|date',
        'estado' => 'required|string|max:50',
        'items.*.producto_id' => 'required|exists:productos,id',
        'items.*.cantidad' => 'required|integer|min:1',
        'items.*.precio_unitario' => 'required|numeric|min:0',
    ];
    public function mount()
    {
        $this->proveedores = Proveedor::all();
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

    public function crearCompra()
    {
        $this->validate();
        $this->calcularTotal();

        DB::beginTransaction();
        try {
            $compra = Compra::create([
                'codigo' => $this->codigo,
                'proveedor_id' => $this->proveedor_id,
                'comprador_id' => auth()->id(),
                'fecha_compra' => $this->fecha_compra,
                'total' => $this->total,
                'metodo_pago' => $this->metodo_pago,
                'fecha_llegada' => $this->fecha_llegada,
                'estado' => $this->estado,
            ]);

            foreach ($this->items as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario'];
                $compra->detalles()->create([
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();
            Flux::modal('default')->close('crear-compra');
            $this->reset();
            session()->flash('success', 'Compra creada exitosamente.');
            $this->redirectRoute('compra.index', navigate: true);
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Error al crear la compra: ' . $th->getMessage());
            Flux::modal('default')->close('crear-compra');
            $this->reset();
            $this->redirectRoute('compra.index', navigate: true);
        }
    }
    private function generarCodigo()
    {
        $ultimo = Compra::latest('id')->first();
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
        return view('livewire.compra.compra-create', [
            'productos' => \App\Models\Producto::all(),
        ]);
    }
}
