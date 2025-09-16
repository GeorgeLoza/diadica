<div class="p-4 bg-white dark:bg-neutral-900 rounded-xl shadow-md">
    <div class="flex items-center justify-between mb-4">
        <div>
            <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white">Clientes</flux:heading>
            <flux:text class="mt-1 text-neutral-600 dark:text-neutral-300">Administración de clientes.</flux:text>
        </div>
        <livewire:cliente.clienteCreate />

    </div>
    <flux:separator variant="solid" class="my-4"></flux:separator>
    <livewire:cliente.clienteEdit />


    {{-- Notificación de error --}}
    @session('error')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false }, 3000)"
            class="fixed button-3 left-3 z-50 w-96 p-4 bg-red-500 text-white text-xs border border-red-300 dark:border-red-700 rounded-lg shadow-lg transition-opacity duration-300"
            role="alert">
            <p>{{ $value }}</p>
        </div>
    @endsession
    {{-- Notificación de éxito --}}
    @session('success')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false }, 3000)"
            class="fixed button-1 left-1 z-50 w-96 p-4 bg-green-500 text-white text-xs border border-green-300 dark:border-green-700 rounded-lg shadow-lg transition-opacity duration-300"
            role="alert">
            <p>{{ $value }}</p>
        </div>
    @endsession

    {{-- Filtro rápido global --}}
    <div class="mb-2 flex gap-2 max-w-md">
        <flux:input icon="magnifying-glass" wire:model.live.live="search" placeholder="Buscar en todo..." />
    </div>
    {{-- Tabla de clientes --}}
    <div class="mt-2 overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 text-xs text-left">
            <thead
                class="bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 uppercase tracking-wider">
                <tr>

                    <th class="p-1">Empresa</th>
                    <th class="p-1">Cliente</th>
                    <th class="p-1">NIT/CI</th>
                    <th class="p-1">Teléfono</th>
                    <th class="p-1">Dirección</th>
                    <th class="p-1">Crédito</th>
                    <th class="p-1">Saldo</th>
                    <th class="p-1">Fecha Ingreso</th>
                    <th class="p-1">Estado</th>
                    <th class="p-1">Acciones</th>

                </tr>
                <tr>
                    {{-- Filtros por columna --}}

                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterNombreEmpresa"
                            placeholder="Filtrar Empresa" class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterNombreCliente"
                            placeholder="Filtrar Cliente" class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterNitCi"
                            placeholder="Filtrar NIT/CI" class="w-full px-1 py-0.5 border rounded" />
                    </th>

                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterTelefono"
                            placeholder="Filtrar Teléfono" class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="p-1">

                        <flux:select wire:model.live="filterEstado" label="Estado" placeholder="Estado">
                            <flux:select.option value="1">Activo</flux:select.option>
                            <flux:select.option value="0">Inactivo</flux:select.option>
                        </flux:select>
                    </th>
                    <th></th>
                </tr>

            </thead>
            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800 bg-white dark:bg-neutral-900">
                @forelse ($clientes as $cliente)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800 transition">
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $cliente->nombre_empresa }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $cliente->nombre_cliente }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $cliente->nit_ci }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $cliente->telefono }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $cliente->direccion }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $cliente->credito }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $cliente->saldo }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $cliente->fecha_ingreso }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">
                            {{ $cliente->estado ? 'Activo' : 'Inactivo' }}</td>
                        <td class="p-1 space-x-2">
                            <flux:button size="xs" variant="primary" color="blue" icon="pencil-square"
                                wire:click="edit({{ $cliente->id }})">

                            </flux:button>

                            <flux:modal.trigger name="delete-profile">
                                <flux:button size="xs" icon="trash" variant="danger"
                                    wire:click="delete({{ $cliente->id }})">
                                </flux:button>
                            </flux:modal.trigger>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-1 text-center text-neutral-500 dark:text-neutral-400">No hay
                            clientes disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $clientes->links() }}
        </div>

        <flux:modal name="delete-cliente" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Eliminar cliente?</flux:heading>
                    <flux:text class="mt-2">
                        <p>Está a punto de eliminar este cliente.</p>
                        <p>Esta acción no se puede deshacer.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="danger" wire:click="deleteCliente">Eliminar cliente
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>
