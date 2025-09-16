<div>

    <flux:modal name="edit-producto" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar producto</flux:heading>
                <flux:text class="mt-2">Complete los detalles del producto.</flux:text>
            </div>
<form wire:submit.prevent="updateProducto" class="space-y-4">
            <flux:input wire:model="codigo" label="Código" placeholder="Código del producto" />
                <flux:input wire:model="nombre" label="Nombre" placeholder="Nombre del producto" />
                <flux:input wire:model="descripcion" label="Descripción" placeholder="Descripción del producto" />
                <flux:input wire:model="unidad_medida" label="Unidad de medida" placeholder="Unidad de medida" />
                <flux:select wire:model="categoria" label="Categoría" placeholder="Categoría del producto">
                    <flux:select.option>Acero</flux:select.option>
                    <flux:select.option>Poliestireno</flux:select.option>
                    <flux:select.option>Accesorios de Anclaje</flux:select.option>
                    <flux:select.option>Maquina</flux:select.option>
                </flux:select>
                
            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Actualizar</flux:button>
            </div>
</form>
        </div>
    </flux:modal>
</div>
