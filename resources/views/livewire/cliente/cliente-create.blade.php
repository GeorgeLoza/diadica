<div>
    <div class="w-full flex justify-end mb-4">
        <flux:modal.trigger name="crear-cliente">
            <flux:button size="sm" icon="plus" variant="primary"  color="green">Crear Cliente</flux:button>
        </flux:modal.trigger>
    </div>
    <flux:modal name="crear-cliente" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear cliente</flux:heading>
                <flux:text class="mt-2">Complete los detalles del nuevo cliente.</flux:text>
            </div>
            <form wire:submit.prevent="createCliente" class="space-y-4">
                <flux:input wire:model="nombre_empresa" label="Nombre de la empresa" placeholder="Nombre de la empresa" />
                <flux:input wire:model="nombre_cliente" label="Nombre del cliente" placeholder="Nombre del cliente" />
                <flux:input wire:model="nit_ci" label="NIT/CI" placeholder="NIT/CI" />
                <flux:input wire:model="telefono" label="Teléfono" placeholder="Teléfono" />
                <flux:input wire:model="direccion" label="Dirección" placeholder="Dirección" />
                <flux:input wire:model="credito" label="Crédito" placeholder="Crédito" type="number" />
                <flux:input wire:model="saldo" label="Saldo" placeholder="Saldo" type="number" />
                <flux:select wire:model="estado" label="Estado" placeholder="Estado">
                    <flux:select.option value="1">Activo</flux:select.option>
                    <flux:select.option value="0">Inactivo</flux:select.option>
                </flux:select>

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Crear Cliente</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>

