<div class="p-4 bg-white dark:bg-neutral-900 rounded-xl shadow-md">
    <div class="flex items-center justify-between mb-4">
        <div>
            <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white">Pagos</flux:heading>
        </div>
        <livewire:pago.pagoCreate />

    </div>
    <flux:separator variant="solid" class="my-4"></flux:separator>
    <livewire:pago.pagoEdit />
    @include('partials.toast')
    {{-- Filtro rápido global --}}
    <div class="mb-2 flex gap-2 max-w-md">
        <flux:input icon="magnifying-glass" wire:model.live.live="search" placeholder="Buscar en todo..." />
    </div>
    {{-- Tabla de pago --}}
    <div class="mt-2 overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 text-xs text-left">
            <thead
                class="bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 uppercase tracking-wider">
                <tr>

                    <th class="p-1">Codigo</th>
                    <th class="p-1">Lugar</th>
                    <th class="p-1" nowrap>Recibi De</th>
                    <th class="p-1">Tiempo</th>
                    <th class="p-1">Tipo</th>
                    <th class="p-1">Concepto</th>
                    <th class="p-1">Comprobante</th>
                    <th class="p-1">Monto</th>
                    <th class="p-1">Moneda</th>
                    <th class="p-1">Total</th>
                    <th class="p-1">Estado</th>
                    <th class="p-1">Trabajador</th>
                    <th class="p-1">Cliente</th>
                    <th class="p-1">Acciones</th>

                </tr>
                <tr>
                    {{-- Filtros por columna --}}

                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterCodigo" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterLugarPago" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterRecibiDe" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterTiempo" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterTipoPago" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterConcepto" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterComprobante" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterMonto" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterMoneda" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterTotal" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterEstado" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterTrabajador" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterCliente" placeholder=""
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800 bg-white dark:bg-neutral-900">
                @forelse ($pagos as $pago)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800 transition">
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->codigo }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->lugar_pago }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->recibi_de }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200" nowrap>
                            {{ \Carbon\Carbon::parse($pago->tiempo)->format('H:i d/m/y') }}
                        </td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->tipo_pago }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->concepto }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->comprobante }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->monto }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->moneda }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->total }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->estado }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->trabajador->name }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $pago->cliente->name }}</td>
                        <td class="p-1 space-x-2">


                            <flux:button size="xs" variant="primary" color="blue" icon="pencil-square"
                                wire:click="edit({{ $pago->id }})">

                            </flux:button>

                            <flux:modal.trigger name="delete-pago">
                                <flux:button size="xs" icon="trash" variant="danger"
                                    wire:click="delete({{ $pago->id }})">
                                </flux:button>
                            </flux:modal.trigger>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-1 text-center text-neutral-500 dark:text-neutral-400">No hay
                            pagos disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $pagos->links() }}
        </div>

        {{-- modal para preguntar si eliminar pago --}}

        <flux:modal name="delete-pago" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Eliminar pago?</flux:heading>
                    <flux:text class="mt-2">
                        <p>Está a punto de eliminar este pago.</p>
                        <p>Esta acción no se puede deshacer.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="danger" wire:click="deletePago">Eliminar pago
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>
