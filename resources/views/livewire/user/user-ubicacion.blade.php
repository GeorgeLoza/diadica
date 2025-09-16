<div>
    <flux:modal name="modal-ubicacion" class="max-w-2xl w-full">
        <div class="space-y-4">
            <div>
                <flux:heading size="md">Ubicaciones de {{ optional($user)->name }}</flux:heading>
                <flux:text class="mt-1 text-sm">Administra las ubicaciones asociadas a este usuario.</flux:text>
            </div>

            {{-- Formulario --}}
            <form wire:submit.prevent="guardarUbicacion" class="space-y-2">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                    <flux:input label="Nombre" placeholder="Nombre" wire:model.defer="nombre" />
                    <flux:input label="Observaciones" placeholder="Observaciones" wire:model.defer="observaciones" />
                    <flux:input label="URL Mapa" placeholder="URL Google Maps" wire:model.defer="url_map" />
                    <flux:input label="Persona Referencia" placeholder="Persona de referencia" wire:model.defer="persona_referencia" />
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

            {{-- Tabla de ubicaciones --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Observaciones</th>
                            <th>URL Mapa</th>
                            <th>Persona Referencia</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ubicaciones as $ubicacion)
                            <tr>
                                <td>{{ $ubicacion->nombre }}</td>
                                <td>{{ $ubicacion->observaciones }}</td>
                                <td>
                                    @if($ubicacion->url_map)
                                        <a href="{{ $ubicacion->url_map }}" target="_blank" class="text-blue-600 underline">Ver mapa</a>
                                    @endif
                                </td>
                                <td>{{ $ubicacion->persona_referencia }}</td>
                                <td class="flex gap-1">
                                    <flux:button size="xs" variant="primary" wire:click="editarUbicacion({{ $ubicacion->id }})" icon="pencil-square" />
                                    <flux:button size="xs" variant="danger" wire:click="eliminarUbicacion({{ $ubicacion->id }})" icon="trash" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-400">Sin ubicaciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </flux:modal>
</div>