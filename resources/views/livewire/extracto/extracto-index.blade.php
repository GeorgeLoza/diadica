<div class="p-4 bg-white dark:bg-neutral-900 rounded-xl shadow-md">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold text-neutral-900 dark:text-white">Extractos de Clientes</h1>
    </div>

    <flux:separator variant="solid" class="my-4"></flux:separator>

    {{-- Tabla de clientes --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 text-sm text-left">
            <thead class="bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 uppercase tracking-wider">
                <tr>
                    <th class="p-2">Cliente</th>
                    <th class="p-2 text-right">Saldo</th>
                    <th class="p-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800 bg-white dark:bg-neutral-900">
                @forelse($clientes as $cliente)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800 transition">
                        <td class="p-2 text-neutral-900 dark:text-neutral-200">
                            {{ $cliente->name }}
                        </td>
                        <td class="p-2 text-right font-medium {{ $saldos[$cliente->id] < 0 ? 'text-red-600' : 'text-green-600' }}">
                            Bs {{ number_format($saldos[$cliente->id], 2) }}
                        </td>
                        <td class="p-2 text-center">
                            <flux:button size="xs" variant="primary" 
                                wire:click="verDetalle({{ $cliente->id }})">
                                Ver Detalle
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-neutral-500 dark:text-neutral-400">
                            No hay clientes registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
