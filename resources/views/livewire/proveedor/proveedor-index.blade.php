<div class="p-4 bg-white dark:bg-neutral-900 rounded-xl shadow-md">
    <div class="flex items-center justify-between mb-4">
        <div>
            <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white">Proveedores</flux:heading>
        </div>
        <livewire:proveedor.proveedorCreate />

    </div>
    <flux:separator variant="solid" class="my-4"></flux:separator>
    <livewire:proveedor.proveedorEdit />

    @include('partials.toast')
    {{-- Filtro rápido global --}}
    <div class="mb-2 flex gap-2 max-w-md">
        <flux:input icon="magnifying-glass" wire:model.live.live="search" placeholder="Buscar en todo..." />
    </div>
    {{-- Tabla de productos --}}
    <div class="mt-2 overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 text-xs text-left">
            <thead
                class="bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 uppercase tracking-wider">
                <tr>

                    <th class="p-1">Nombre</th>
                    <th class="p-1">País de origen</th>
                    <th class="p-1">Contacto Principal</th>
                    <th class="p-1">Telefono</th>
                    <th class="p-1">Email</th>
                    <th class="p-1">Acciones</th>
                </tr>
                <tr>
                    {{-- Filtros por columna --}}
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterNombre" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterPaisOrigen"
                            placeholder="Filtrar" class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterContactoPrincipal"
                            placeholder="Filtrar" class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterTelefono" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterEmail" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>


                </tr>

            </thead>
            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800 bg-white dark:bg-neutral-900">
                @forelse ($proveedores as $proveedor)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800 transition">
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $proveedor->nombre }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $proveedor->pais_origen }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $proveedor->contacto_principal }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $proveedor->telefono }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $proveedor->email }}</td>
                        <td class="p-1 space-x-2">


                            <flux:button size="xs" variant="primary" color="blue" icon="pencil-square"
                                wire:click="edit({{ $proveedor->id }})">
                            </flux:button>

                            <flux:modal.trigger name="delete-proveedor">
                                <flux:button size="xs" icon="trash" variant="danger"
                                    wire:click="delete({{ $proveedor->id }})">
                                </flux:button>
                            </flux:modal.trigger>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-1 text-center text-neutral-500 dark:text-neutral-400">No hay
                            proveedores disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $proveedores->links() }}
        </div>

        {{-- modal para preguntar si eliminar proveedor --}}

        <flux:modal name="delete-proveedor" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Eliminar proveedor?</flux:heading>
                    <flux:text class="mt-2">
                        <p>Está a punto de eliminar este proveedor.</p>
                        <p>Esta acción no se puede deshacer.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="danger" wire:click="deleteProveedor">Eliminar proveedor
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>
