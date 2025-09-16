<div>
    <flux:modal name="modal-contacto" class="max-w-xl w-full">
        <div class="space-y-4">
            <div>
                <flux:heading size="md">Contactos de {{ optional($user)->name }}</flux:heading>
            </div>

            {{-- Formulario --}}
            <form wire:submit.prevent="guardarContacto" class="space-y-2">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-2">
                    <flux:input label="Nombre" placeholder="Nombre" wire:model.defer="nombre" size="sm"/>
                    <flux:input label="Cargo" placeholder="Cargo" wire:model.defer="cargo" size="sm"/>
                    <flux:input label="Teléfono" placeholder="Teléfono" wire:model.defer="telefono" size="sm"/>
                    <flux:input label="Dirección" placeholder="Dirección" wire:model.defer="direccion" size="sm"/>
                    <flux:input label="Correo" placeholder="Correo" wire:model.defer="correo" size="sm"/>
                </div>
                <div class="flex justify-end gap-2">
                    @if($modo === 'editar')
                        <flux:button type="button" size="sm" variant="secondary" wire:click="resetForm">Cancelar</flux:button>
                    @endif
                    <flux:button type="submit" size="sm" variant="primary">
                        {{ $modo === 'crear' ? 'Agregar' : 'Actualizar' }}
                    </flux:button>
                </div>
            </form>

            {{-- Tabla de contactos --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead>
                        <tr>
                            <th class="px-1">Nombre</th>
                            <th class="px-1">Cargo</th>
                            <th class="px-1">Teléfono</th>
                            <th class="px-1">Dirección</th>
                            <th class="px-1">Correo</th>
                            <th class="px-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contactos as $contacto)
                            <tr>
                                <td class="px-1">{{ $contacto->nombre }}</td>
                                <td class="px-1">{{ $contacto->cargo }}</td>
                                <td class="px-1">{{ $contacto->telefono }}</td>
                                <td class="px-1">{{ $contacto->direccion }}</td>
                                <td class="px-1">{{ $contacto->correo }}</td>
                                <td class="flex gap-1">
                                    <flux:button size="xs" variant="primary" wire:click="editarContacto({{ $contacto->id }})" icon="pencil-square" />
                                    <flux:button size="xs" variant="danger" wire:click="eliminarContacto({{ $contacto->id }})" icon="trash" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-400">Sin contactos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </flux:modal>
</div>