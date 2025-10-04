{{-- filepath: resources/views/livewire/pago/pago-create.blade.php --}}
<div>
    <div class="w-full flex justify-end mb-2">
        <flux:modal.trigger name="crear-pago">
            <flux:button size="sm" icon="plus" variant="primary" color="green">Crear Pago</flux:button>
        </flux:modal.trigger>
    </div>
    <flux:modal name="crear-pago" variant="flyout">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Crear pago</flux:heading>
                <flux:text class="mt-1 text-xs">Complete los campos del nuevo pago.</flux:text>
            </div>
            <form wire:submit.prevent="createPago" class="space-y-2">
                <div class="flex flex-col gap-2">
                    <flux:input wire:model="lugar_pago" label="Lugar de Pago" placeholder="Lugar de Pago" class="py-1" />
                    <flux:input wire:model="recibi_de" label="Recibí de" placeholder="Recibí de" class="py-1" />
                    <flux:select wire:model="tipo_pago" label="Tipo de Pago" placeholder="Seleccione un tipo de pago" class="py-1">
                        <flux:select.option value="">Seleccione un tipo de pago</flux:select.option>
                        <flux:select.option value="efectivo">Efectivo</flux:select.option>
                        <flux:select.option value="tarjeta">Tarjeta</flux:select.option>
                        <flux:select.option value="transferencia">Transferencia</flux:select.option>
                        <flux:select.option value="cheque">Cheque</flux:select.option>
                    </flux:select>
                    <flux:input wire:model="concepto" label="Concepto" placeholder="Concepto" class="py-1" />
                    <flux:input wire:model="comprobante" label="Comprobante" placeholder="Comprobante" class="py-1" />
                    <div class="flex gap-2">
                        <flux:input wire:model.live="monto" label="Monto" placeholder="Monto" class="w-1/2 py-1" type="number" min="0" step="0.01" />
                        <flux:select wire:model.live="moneda" label="Moneda" class="w-1/2 py-1">
                            <flux:select.option value="bs">Bs</flux:select.option>
                            <flux:select.option value="dolar">Dólar</flux:select.option>
                            <flux:select.option value="euro">Euro</flux:select.option>
                        </flux:select>
                    </div>
                    <flux:input wire:model.live="tipo_cambio" label="Tipo de Cambio" placeholder="Tipo de cambio actual" class="py-1" type="number" min="0.0001" step="0.0001" />
                    <flux:input wire:model.live="total" label="Total" placeholder="Total" class="py-1" readonly />
                    
                    <flux:select wire:model="cliente_id" label="Cliente" placeholder="Seleccione un cliente" class="py-1">
                        <flux:select.option value="">Seleccione un cliente</flux:select.option>
                        @foreach ($clientes as $cliente)
                            <flux:select.option value="{{ $cliente->id }}">{{ $cliente->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="flex justify-end pt-2">
                    <flux:button type="submit" variant="primary">Crear pago</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>