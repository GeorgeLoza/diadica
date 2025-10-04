<div class="p-4 bg-white dark:bg-neutral-900 rounded-xl shadow-md">
    <div class="flex items-center justify-between mb-4">
        <div>
            <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white">Compras</flux:heading>
        </div>
        <livewire:compra.compraCreate />

    </div>
    <flux:separator variant="solid" class="my-4"></flux:separator>
    <livewire:compra.compraEdit />
    @include('partials.toast')
    {{-- Filtro rápido global --}}
    <div class="mb-2 flex gap-2 max-w-md">
        <flux:input icon="magnifying-glass" wire:model.live.live="search" placeholder="Buscar en todo..." />
    </div>
    {{-- Tabla de compras --}}
    <div class="mt-2 overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 text-xs text-left">
            <thead
                class="bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 uppercase tracking-wider">
                <tr>

                    <th class="p-1">Codigo</th>
                    <th class="p-1">Proveedor</th>
                    <th class="p-1">Comprador</th>
                    <th class="p-1">Fecha de Compra</th>
                    <th class="p-1">Total</th>
                    <th class="p-1">Metodo de Pago</th>
                    <th class="p-1">Fecha de llegada</th>
                    <th class="p-1">Estado</th>
                    <th class="p-1">Acciones</th>
                </tr>
                <tr>
                    {{-- Filtros por columna --}}

                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterCodigo" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterProveedor"
                            placeholder="Filtrar" class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterComprador"
                            placeholder="Filtrar" class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterFechaCompra"
                            placeholder="Filtrar" class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterTotal" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                </tr>

            </thead>
            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800 bg-white dark:bg-neutral-900">

                @forelse ($compras as $compra)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800 transition">
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $compra->codigo }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $compra->proveedor->nombre }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $compra->comprador->name }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $compra->fecha_compra }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $compra->total }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $compra->metodo_pago }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $compra->fecha_llegada }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $compra->estado }}</td>
                        <td class="p-1 space-x-2 flex items-center">
                            <flux:button size="xs" variant="primary" color="blue" icon="pencil-square"
                                wire:click="edit({{ $compra->id }})">
                            </flux:button>
                            <flux:modal.trigger name="delete-compra">
                                <flux:button size="xs" icon="trash" variant="danger"
                                    wire:click="delete({{ $compra->id }})">
                                </flux:button>
                            </flux:modal.trigger>
                            <flux:button size="xs" icon="chevron-down"
                                wire:click="toggleDetalle({{ $compra->id }})">
                            </flux:button>
                        </td>
                    </tr>
                    @if ($expandedCompraId === $compra->id)
                        <tr>
                            <td colspan="9" class="bg-neutral-50 dark:bg-neutral-800">
                                <div class="p-2">
                                    <strong>Ítems de la compra:</strong>
                                    <table class="min-w-full text-xs mt-2">
                                        <thead>
                                            <tr>
                                                <th class="p-1">Producto</th>
                                                <th class="p-1">Cantidad</th>
                                                <th class="p-1">Precio Unitario</th>
                                                <th class="p-1">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($compra->detalles as $item)
                                                <tr>
                                                    <td class="p-1">{{ $item->producto->nombre ?? '-' }}</td>
                                                    <td class="p-1">{{ $item->cantidad }}</td>
                                                    <td class="p-1">{{ $item->precio_unitario }}</td>
                                                    <td class="p-1">{{ $item->subtotal }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="9" class="p-1 text-center text-neutral-500 dark:text-neutral-400">No hay compras
                            disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $compras->links() }}
        </div>

        {{-- modal para preguntar si eliminar compra --}}

        <flux:modal name="delete-compra" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Eliminar compra?</flux:heading>
                    <flux:text class="mt-2">
                        <p>Está a punto de eliminar esta compra.</p>
                        <p>Esta acción no se puede deshacer.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="danger" wire:click="deleteCompra">Eliminar compra
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>
