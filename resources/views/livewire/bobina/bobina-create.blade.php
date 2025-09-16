<div>
    <div class="w-full flex justify-end mb-4">
        <flux:modal.trigger name="crear-bobina">
            <flux:button size="sm" icon="plus" variant="primary" color="green">Crear Bobina</flux:button>
        </flux:modal.trigger>
    </div>
    <flux:modal name="crear-bobina" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear bobina</flux:heading>
                <flux:text class="mt-2">Complete los campos de la nueva bobina.</flux:text>
            </div>
            <form wire:submit.prevent="createBobina" class="space-y-4">
                <flux:input wire:model="id_bobina" label="ID de la bobina" placeholder="ID de la bobina" />
                <flux:input wire:model="id_producto" label="ID del producto" placeholder="ID del producto" />
                <flux:input wire:model="peso" label="Peso(kg)" placeholder="Peso de la bobina" />
                <flux:input wire:model="lote" label="Lote" placeholder="Lote de la bobina" />
                <flux:select wire:model="estado" label="Estado" placeholder="Estado de la bobina">
                    <flux:select.option>Disponible</flux:select.option>
                    <flux:select.option>Reservado</flux:select.option>
                    <flux:select.option>Vendido</flux:select.option>
                </flux:select>
                <flux:input wire:model="costo_unitario" label="Costo unitario" placeholder="Costo unitario" />
            </form>

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Crear bobina</flux:button>
            </div>
        </form>
        </div>
    </flux:modal>
</div>