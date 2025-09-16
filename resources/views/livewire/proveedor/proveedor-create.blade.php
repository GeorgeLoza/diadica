<div>
    <div class="w-full flex justify-end mb-4">
        <flux:modal.trigger name="crear-proveedor">
            <flux:button size="sm" icon="plus" variant="primary" color="green">Crear Proveedor</flux:button>
        </flux:modal.trigger>
    </div>
    <flux:modal name="crear-proveedor" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear proveedor</flux:heading>
                <flux:text class="mt-2">Complete los campos del nuevo proveedor.</flux:text>
            </div>
            <form wire:submit.prevent="createProveedor" class="space-y-4">
                <flux:input wire:model="nombre" label="Nombre" placeholder="Nombre del proveedor" />
                <flux:input wire:model="pais_origen" label="País de Origen"
                    placeholder="País de origen del proveedor" />
                <flux:input wire:model="contacto_principal" label="Contacto Principal"
                    placeholder="Nombre del contacto principal" />
                <flux:input wire:model="telefono" label="Teléfono" placeholder="Teléfono del proveedor" />
                <flux:input wire:model="email" label="Email" placeholder="Email del proveedor" />
              

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Crear proveedor</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
