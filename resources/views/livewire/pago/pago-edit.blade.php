<div>

    <flux:modal name="edit-producto" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar pago</flux:heading>
                <flux:text class="mt-2">Complete los detalles del pago.</flux:text>
            </div>
            <form wire:submit.prevent="updatePago" class="space-y-4">
                <flux:input wire:model="codigo" label="Código" placeholder="Código del pago" />
                <flux:input wire:model="lugar_pago" label="Lugar de Pago" placeholder="Lugar de Pago" />
                <flux:input wire:model="recibi_de" label="Recibí de" placeholder="Recibí de" />
                <flux:input wire:model="tipo_pago" label="Tipo de Pago" placeholder="Tipo de Pago" />
                <flux:input wire:model="concepto" label="Concepto" placeholder="Concepto" />
                <flux:input wire:model="comprobante" label="Comprobante" placeholder="Comprobante" />
                <flux:input wire:model="monto" label="Monto" placeholder="Monto" />
                <flux:input wire:model="moneda" label="Moneda" placeholder="Moneda" />
                <flux:input wire:model="total" label="Total" placeholder="Total" />
                <flux:input wire:model="estado" label="Estado" placeholder="Estado" />
                <flux:select wire:model="trabajador_id" label="Trabajador" placeholder="Seleccione un trabajador">
                    <flux:select.option value="">Seleccione un trabajador</flux:select.option>
                    @foreach ($trabajadores as $trabajador)
                        <flux:select.option value="{{ $trabajador->id }}">{{ $trabajador->nombre }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select wire:model="cliente_id" label="Cliente" placeholder="Seleccione un cliente">
                    <flux:select.option value="">Seleccione un cliente</flux:select.option>
                    @foreach ($clientes as $cliente)
                        <flux:select.option value="{{ $cliente->id }}">{{ $cliente->nombre }}</flux:select.option>
                    @endforeach
                </flux:select>
                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Actualizar</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
