<div>

    <flux:modal name="edit-user" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar usuario</flux:heading>
                <flux:text class="mt-2">Complete los detalles del usuario.</flux:text>
            </div>
            <form wire:submit.prevent="updateUser" class="space-y-4">
                <flux:input wire:model="name" label="Name" placeholder="Tu nombre" />
                <flux:input wire:model="email" label="Email" placeholder="Tu email" />
                <flux:select wire:model="rol" label="Rol" placeholder="Seleccione un rol">
                    <flux:select.option value="">Seleccione un rol</flux:select.option>
                    <flux:select.option value="admin">Administrador</flux:select.option>
                    <flux:select.option value="cliente">Cliente</flux:select.option>
                    <flux:select.option value="trabajador">Trabajador</flux:select.option>
                </flux:select>
                <flux:input wire:model="estado" label="Estado" placeholder="Estado del usuario" />
                <flux:input wire:model="password" label="Password" placeholder="Tu contraseña" type="password" />
                <flux:input wire:model="empresa" label="Empresa" placeholder="Tu empresa" />
                <flux:input wire:model="razon_social" label="Razón Social" placeholder="Tu razón social" />
                <flux:input wire:model="nit" label="NIT" placeholder="Tu NIT" />

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Actualizar</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
