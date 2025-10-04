<div class="p-4 bg-white dark:bg-neutral-900 rounded-xl shadow-md">
    @if($cliente)
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold text-neutral-900 dark:text-white">
                Extracto de {{ $cliente->name }}
            </h1>
        </div>

        <flux:separator variant="solid" class="my-4"></flux:separator>

        {{-- Tabla de movimientos --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 text-sm text-left">
                <thead class="bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 uppercase tracking-wider">
                    <tr>
                        <th class="p-2">Fecha</th>
                        <th class="p-2">Concepto</th>
                        <th class="p-2 text-right">Monto</th>
                        <th class="p-2 text-right">Saldo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800 bg-white dark:bg-neutral-900">
                    @forelse($movimientos as $mov)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800 transition">
                            <td class="p-2 text-neutral-900 dark:text-neutral-200">
                                {{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y') }}
                            </td>
                            <td class="p-2 text-neutral-900 dark:text-neutral-200">
                                {{ $mov['concepto'] }}
                            </td>
                            <td class="p-2 text-right font-medium 
                                {{ $mov['tipo'] === 'venta' ? 'text-red-600' : 'text-green-600' }}">
                                {{ $mov['tipo'] === 'venta' ? '- ' : '+ ' }}
                                Bs {{ number_format(abs($mov['monto']), 2) }}
                            </td>
                            <td class="p-2 text-right font-semibold">
                                Bs {{ number_format($mov['saldo'], 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-neutral-500 dark:text-neutral-400">
                                No hay movimientos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Saldo final --}}
        <div class="mt-4 p-4 bg-neutral-100 dark:bg-neutral-800 rounded-lg">
            <p class="text-lg font-semibold text-neutral-900 dark:text-neutral-200">
                Saldo final:
                <span class="{{ $saldo < 0 ? 'text-red-600' : 'text-green-600' }}">
                    Bs {{ number_format($saldo, 2) }}
                </span>
            </p>
        </div>
    @else
        <p class="text-neutral-500 dark:text-neutral-400">
            Seleccione un cliente desde el listado para ver el extracto.
        </p>
    @endif
</div>
