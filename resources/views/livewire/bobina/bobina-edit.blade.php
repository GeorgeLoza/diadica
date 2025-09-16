<div>

    <flux:modal name="edit-bobina" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar bobina</flux:heading>
                <flux:text class="mt-2">Complete los detalles de la bobina.</flux:text>
            </div>
<form wire:submit.prevent="updateBobina" class="space-y-4">
            <flux:input wire:model="id_bobina" label="ID de la bobina" placeholder="ID de la bobina" />
                <flux:input wire:model="id_producto" label="ID del producto" placeholder="ID del producto" />
                <flux:input wire:model="peso" label="Peso" placeholder="Peso de la bobina" />
                <flux:input wire:model="lote" label="Lote" placeholder="Lote de la bobina" />
                <flux:input wire:model="estado" label="Estado" placeholder="Estado de la bobina" />
                <flux:input wire:model="costo_unitario" label="Costo unitario" placeholder="Costo unitario" />
            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Actualizar</flux:button>
            </div>
</form>
        </div>
    </flux:modal>
</div>
