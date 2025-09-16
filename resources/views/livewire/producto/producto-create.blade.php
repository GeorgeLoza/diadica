<div>
    <div class="w-full flex justify-end mb-4">
        <flux:modal.trigger name="crear-producto">
            <flux:button size="sm" icon="plus" variant="primary" color="green">Crear Producto</flux:button>
        </flux:modal.trigger>
    </div>
    <flux:modal name="crear-producto" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear producto</flux:heading>
                <flux:text class="mt-2">Complete los campos del nuevo producto.</flux:text>
            </div>
            <form wire:submit.prevent="createProduct" class="space-y-4">
                <flux:input wire:model="codigo" label="Código" placeholder="Código del producto" />
                <flux:input wire:model="nombre" label="Nombre" placeholder="Nombre del producto" />
                <flux:input wire:model="descripcion" label="Descripción" placeholder="Descripción del producto" />
                <flux:input wire:model="unidad_medida" label="Unidad de Medida" placeholder="Unidad de Medida" />
                <flux:select wire:model="categoria" label="Categoría" placeholder="Categoría del producto">
                    <flux:select.option>Acero</flux:select.option>
                    <flux:select.option>Poliestireno</flux:select.option>
                    <flux:select.option>Accesorios de Anclaje</flux:select.option>
                    <flux:select.option>Maquina</flux:select.option>
                </flux:select>

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Crear producto</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
