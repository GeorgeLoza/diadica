<?php

namespace App\Livewire\Dashboard;

use App\Models\Compra;
use App\Models\DetalleVenta;
use App\Models\Pago;
use App\Models\User;
use App\Models\Venta;
use Livewire\Component;

class DashboardIndex extends Component
{
     public $totales = [];
    public $clientesDeudores = [];
    public $comprasRecientes = [];
    public $ventasRecientes = [];
    public $topProductos = [];

    public function mount()
    {
        // Totales
        $totalVentas = Venta::sum('total');
        $totalCompras = Compra::sum('total');
        $totalPagos = Pago::sum('monto');
        $deudaTotal = $totalVentas - $totalPagos; // lo que los clientes aún deben

        $this->totales = [
            'total_ventas' => $totalVentas,
            'total_compras' => $totalCompras,
            'total_pagos' => $totalPagos,
            'deuda_total' => $deudaTotal,
        ];

        // Clientes con más deuda (top 5)
        $this->clientesDeudores = User::where('rol', 'cliente')
            ->get()
            ->map(function ($cliente) {
                $ventas = Venta::where('cliente_id', $cliente->id)->sum('total');
                $pagos = Pago::where('cliente_id', $cliente->id)->sum('monto');
                $cliente->deuda = $ventas - $pagos;
                return $cliente;
            })
            ->filter(fn($c) => $c->deuda > 0)
            ->sortByDesc('deuda')
            ->take(5);

        // Compras recientes
        $this->comprasRecientes = Compra::with('proveedor')
            ->latest()->take(5)->get();

        // Ventas recientes
        $this->ventasRecientes = Venta::with('cliente')
            ->latest()->take(5)->get();

        // Productos más vendidos
        $this->topProductos = DetalleVenta::with('producto')
            ->selectRaw('producto_id, SUM(cantidad) as total_cantidad, SUM(subtotal) as total_monto')
            ->groupBy('producto_id')
            ->orderByDesc('total_cantidad')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-index');
    }
}
