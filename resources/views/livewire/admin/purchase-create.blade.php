<div x-data="{
    products: @entangle('products'),
    total: @entangle('total'),
    removeProduct(index) {
        this.products.splice(index, 1);
    },
    init() {
        this.$watch('products', (newProducts) => {
            let total = 0;
            (newProducts || []).forEach(p => {
                const q = Number(p.quantity) || 0;
                const pr = Number(p.price) || 0;
                total += q * pr;
            });
            this.total = total;
        });
    },
}">
    <x-wire-card>
        <form wire:submit='save' class="space-y-4">
            <div class="grid gap-4 lg:grid-cols-4">
                <x-wire-native-select label='Tipo de Comprobante' wire:model='voucher_type'>
                    <option value="1">Factura</option>
                    <option value="2">Boleta</option>
                </x-wire-native-select>
                <div class="grid grid-cols-2 gap-2">
                    <x-wire-input label='Serie' wire:model='serie' placeholder="Serie del comprobante" />
                    <x-wire-input label='Correlativo' wire:model='correlative'
                        placeholder="Correlativo del comprobante" />
                </div>
                <x-wire-input label='Fecha' wire:model='date' type='date' />

                <x-wire-select label='Orden de Compra' wire:model.live='purchase_order_id' :async-data="[
                    'api' => route('api.purchase-orders.index'),
                    'method' => 'POST',
                ]"
                    option-label="name" option-value="id" placeholder="Selecciona un orden de compra"
                    option-description="description" />

                <div class="col-span-2">
                    <x-wire-select label='Proveedor' wire:model='supplier_id' :async-data="[
                        'api' => route('api.suppliers.index'),
                        'method' => 'POST',
                    ]" option-label="name"
                        option-value="id" placeholder="Selecciona un proveedor" />
                </div>
                <div class="col-span-2">
                    <x-wire-select label='Almacen' wire:model='warehouse_id' :async-data="[
                        'api' => route('api.warehouses.index'),
                        'method' => 'POST',
                    ]" option-label="name"
                        option-value="id" placeholder="Selecciona un almacen" option-description="description" />
                </div>
            </div>



            <div class="lg:flex lg:space-x-4">
                <x-wire-select label='Productos' wire:model='product_id' :async-data="[
                    'api' => route('api.products.index'),
                    'method' => 'POST',
                ]" option-label="name"
                    option-value="id" placeholder="Selecciona un producto" class="flex-1" />
                <div class="flex-shrink-0">
                    <x-wire-button wire:click='addProduct' spinner='addProduct' type="button"
                        class="lg:mt-6.5 mt-4 w-full">Agregar
                        Producto</x-wire-button>
                </div>
            </div>
            <div class="w-full overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-700 border-y bg-blue-50">
                            <th class="px-4 py-2">Producto</th>
                            <th class="px-4 py-2">Cantidad</th>
                            <th class="px-4 py-2">Precio</th>
                            <th class="px-4 py-2">Subtotal</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(product, index) in products" :key="product.id">
                            <tr class="border-b">
                                <td class="px-4 py-2" x-text="product.name"></td>
                                <td class="px-4 py-2">
                                    <x-wire-input type="number" class="w-20" x-model='product.quantity' />
                                </td>
                                <td class="px-4 py-2">
                                    <x-wire-input type="number" class="w-20" x-model='product.price'
                                        step="0.01" />
                                </td>
                                <td class="px-4 py-2" x-text="(product.quantity * product.price).toFixed(2)"></td>
                                <td class="px-4 py-2">
                                    <x-wire-mini-button x-on:click="removeProduct(index)" rounded icon="trash"
                                        color="red" />
                                </td>
                            </tr>
                        </template>
                        <template x-if="products.length === 0">
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">
                                    No hay Productos Agregados
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center space-x-4">
                <x-label>
                    Observaciones
                </x-label>
                <x-wire-input wire:model='observation' placeholder="Observaciones" class="flex-1" />
                <div>
                    Total: COP <span x-text="total.toFixed(2)"></span>
                </div>
            </div>
            <div class="flex justify-end">
                <x-wire-button type="submit" spinner="save" icon="check">
                    Guardar
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>
</div>
