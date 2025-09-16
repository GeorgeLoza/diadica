<div class="p-4 bg-white dark:bg-neutral-900 rounded-xl shadow-md">
    <div class="flex items-center justify-between mb-4">
        <div>
            <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white">Usuarios</flux:heading>
        </div>
        <livewire:user.userCreate />

    </div>
    <flux:separator variant="solid" class="my-4"></flux:separator>
    <livewire:user.userEdit />
    <livewire:user.userContacto />
    <livewire:user.userUbicacion />
    {{-- Modal para confirmar eliminación --}}


    {{-- Filtro rápido global --}}
    <div class="mb-2 flex gap-2 max-w-md">
        <flux:input size="sm" icon="magnifying-glass" wire:model.live.live="search"
            placeholder="Buscar en todo..." />
    </div>
    {{-- Tabla de usuarios --}}
    <div class="mt-2 overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 text-xs text-left">
            <thead
                class="bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 uppercase tracking-wider">
                <tr>

                    <th class="p-1">Nombre</th>
                    <th class="p-1">email</th>
                    <th class="p-1">rol</th>
                    <th class="p-1">estado</th>
                    <th class="p-1">empresa</th>
                    <th class="p-1">razon social</th>
                    <th class="p-1">nit</th>
                    <th class="p-1">Acciones</th>
                </tr>
                <tr>
                    {{-- Filtros por columna --}}

                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterName" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterEmail" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterRol" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterEstado" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterEmpresa" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterRazonSocial"
                            placeholder="Filtrar" class="w-full px-1 py-0.5 border rounded" />
                    </th>
                    <th class="p-1">
                        <flux:input type="text" size="xs" wire:model.live="filterNit" placeholder="Filtrar"
                            class="w-full px-1 py-0.5 border rounded" />
                    </th>
                </tr>

            </thead>
            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800 bg-white dark:bg-neutral-900">
                @forelse ($usuarios as $usuario)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800 transition">
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $usuario->name }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $usuario->email }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $usuario->rol }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $usuario->estado }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $usuario->empresa }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $usuario->razon_social }}</td>
                        <td class="p-1 text-neutral-900 dark:text-neutral-200">{{ $usuario->nit }}</td>
                        <td class="p-1 space-x-2 flex ">


                            <flux:button size="xs" variant="primary" color="yellow" icon="numbered-list"
                                wire:click="contacto({{ $usuario->id }})">
                            </flux:button>
                            <flux:button size="xs" variant="primary" color="green" icon="map-pin"
                                wire:click="ubicacion({{ $usuario->id }})">
                            </flux:button>

                            <flux:button size="xs" variant="primary" color="blue" icon="pencil-square"
                                wire:click="edit({{ $usuario->id }})">
                            </flux:button>

                            <flux:modal.trigger name="delete-profile">
                                <flux:button size="xs" icon="trash" variant="danger"
                                    wire:click="delete({{ $usuario->id }})">
                                </flux:button>
                            </flux:modal.trigger>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-1 text-center text-neutral-500 dark:text-neutral-400">No hay
                            usuarios disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $usuarios->links() }}
        </div>

        <flux:modal name="delete-user" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Eliminar usuario?</flux:heading>
                    <flux:text class="mt-2">
                        <p>Está a punto de eliminar este usuario.</p>
                        <p>Esta acción no se puede deshacer.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="danger" wire:click="deleteUser">Eliminar usuario
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>
