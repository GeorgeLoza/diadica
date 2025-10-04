<div>
    <div class="w-full flex justify-end mb-4">
        <flux:modal.trigger name="crear-venta">
            <flux:button size="sm" icon="plus" variant="primary" color="green">Crear Venta</flux:button>
        </flux:modal.trigger>
    </div>
    <flux:modal name="crear-venta" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear venta</flux:heading>
                <flux:text class="mt-2">Complete los campos de la nueva venta.</flux:text>
            </div>
            <form wire:submit.prevent="crearVenta" class="space-y-4">
                <flux:input wire:model="codigo" label="Código" placeholder="Código de la venta" />
                <flux:select wire:model="cliente_id" label="Cliente" placeholder="Seleccione un cliente"  selected>
                    @foreach ($clientes as $cliente)
                        <flux:select.option value="{{ $cliente->id }}">{{ $cliente->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input type="date" wire:model="fecha_venta" label="Fecha de Venta" placeholder="Fecha de Venta" />
                <flux:input wire:model="total" label="Total" placeholder="Total de la venta" readonly  />
                <flux:select wire:model="estado" label="Estado" placeholder="Estado de la venta">
                    <flux:select.option value="pendiente">Pendiente</flux:select.option>
                    <flux:select.option value="recibido">Recibido</flux:select.option>
                    <flux:select.option value="cancelado">Cancelado</flux:select.option>
                </flux:select>
                {{-- //aca van los items a ventas con la ocionde de agregar muchos a la misma venta --}}

                <div class="space-y-4">
                    <flux:heading size="md">Productos</flux:heading>
                    @foreach ($items as $index => $item)
                        <div class="flex gap-2 items-end">
                            <flux:select wire:model="items.{{ $index }}.producto_id" label="Producto">
                                @foreach ($productos as $producto)
                                    <flux:select.option value="{{ $producto->id }}">{{ $producto->nombre }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                            <flux:input type="number" min="1" wire:model="items.{{ $index }}.cantidad"
                                label="Cantidad" />
                            <flux:input type="number" min="0" step="0.01"
                                wire:model="items.{{ $index }}.precio_unitario" label="Precio Unitario" />
                            <flux:button type="button" color="red" icon="trash"
                                wire:click="removeItem({{ $index }})" />
                        </div>
                    @endforeach
                    <flux:button type="button" color="blue" icon="plus" wire:click="addItem">Agregar Producto
                    </flux:button>
                </div>

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Crear venta</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
