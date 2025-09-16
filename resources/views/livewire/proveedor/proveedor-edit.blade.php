<div>

    <flux:modal name="edit-proveedor" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar proveedor</flux:heading>
                <flux:text class="mt-2">Complete los detalles del proveedor.</flux:text>
            </div>
<form wire:submit.prevent="updateProveedor" class="space-y-4">
            <flux:input wire:model="nombre" label="Nombre" placeholder="Empresa del proveedor" />
                <flux:input wire:model="pais_origen" label="País" placeholder="país" />
                <flux:input wire:model="contacto_principal" label="Contacto principal" placeholder="Nombre del contacto" />
                <flux:input wire:model="telefono" label="Teléfono" placeholder="Número de teléfono" />
                <flux:input wire:model="email" label="Email" placeholder="Correo electrónico" type="email" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Actualizar</flux:button>
            </div>
</form>
        </div>
    </flux:modal>
</div>
