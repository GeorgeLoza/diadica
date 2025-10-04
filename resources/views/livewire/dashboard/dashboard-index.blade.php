<div class="p-6 space-y-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">📊 Dashboard</h1>

    {{-- Totales generales --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
            <h2 class="text-sm font-medium text-gray-500">Total Ventas</h2>
            <p class="text-2xl font-bold text-green-600">Bs {{ number_format($totales['total_ventas'], 2) }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
            <h2 class="text-sm font-medium text-gray-500">Total Compras</h2>
            <p class="text-2xl font-bold text-blue-600">Bs {{ number_format($totales['total_compras'], 2) }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
            <h2 class="text-sm font-medium text-gray-500">Total Pagos</h2>
            <p class="text-2xl font-bold text-indigo-600">Bs {{ number_format($totales['total_pagos'], 2) }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
            <h2 class="text-sm font-medium text-gray-500">Deuda Total</h2>
            <p class="text-2xl font-bold {{ $totales['deuda_total'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                Bs {{ number_format($totales['deuda_total'], 2) }}
            </p>
        </div>
    </div>

    {{-- Clientes con más deuda --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
        <h2 class="text-lg font-bold mb-3 text-gray-700 dark:text-gray-200">Clientes con más deuda</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                    <th class="p-2">Cliente</th>
                    <th class="p-2 text-right">Deuda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientesDeudores as $cliente)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="p-2">{{ $cliente->name }}</td>
                        <td class="p-2 text-right text-red-600 font-bold">
                            Bs {{ number_format($cliente->deuda, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Compras y ventas recientes --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
            <h2 class="text-lg font-bold mb-3 text-gray-700 dark:text-gray-200">Últimas Compras</h2>
            <ul class="text-sm">
                @foreach($comprasRecientes as $compra)
                    <li class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                        <span>{{ $compra->codigo }} - {{ $compra->proveedor->nombre }}</span>
                        <span class="font-bold text-blue-600">Bs {{ number_format($compra->total, 2) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
            <h2 class="text-lg font-bold mb-3 text-gray-700 dark:text-gray-200">Últimas Ventas</h2>
            <ul class="text-sm">
                @foreach($ventasRecientes as $venta)
                    <li class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                        <span>{{ $venta->codigo }} - {{ $venta->cliente->name }}</span>
                        <span class="font-bold text-green-600">Bs {{ number_format($venta->total, 2) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Top productos vendidos --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
        <h2 class="text-lg font-bold mb-3 text-gray-700 dark:text-gray-200">Productos más vendidos</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                    <th class="p-2">Producto</th>
                    <th class="p-2 text-right">Cantidad</th>
                    <th class="p-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProductos as $prod)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="p-2">{{ $prod->producto->nombre }}</td>
                        <td class="p-2 text-right">{{ $prod->total_cantidad }}</td>
                        <td class="p-2 text-right font-bold text-indigo-600">
                            Bs {{ number_format($prod->total_monto, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
