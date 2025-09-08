<div>
    <x-wire-alert title="Producto Seleccionado" info class="mb-6">
        <x-slot name="slot" class="italic">
            <p>
                <span class="font-bold">Nombre: </span>
                {{ $product->name }}
            </p>
            <p>
                <span class="font-bold">SKU: </span>
                {{ $product->sku ?? 'No Definido' }}
            </p>
            <p>
                <span class="font-bold">Stock Total: </span>
                {{ $product->stock }}
            </p>

        </x-slot>
    </x-wire-alert>
    <x-wire-card class="mb-6">
        <div class="grid grid-cols-2 gap-4">
            <x-wire-input label="Fecha Inicial" type="date" wire:model.live='fecha_inicial' />
            <x-wire-input label="Fecha Final" type="date" wire:model.live='fecha_final' />

            <x-wire-select class="col-span-2" label="Almacen" wire:model.live='warehouse_id' :options="$warehouses->select('id', 'name')"
                option-label="name" option-value="id" />
        </div>
    </x-wire-card>

    <h2 class="mb-4 text-lg font-semibold text-gray-900">Kardex de Productos</h2>
    @if ($inventories->count())
        <div class="overflow-x-auto border-gray-200 shadow-md rounded-xl">
            <table class="min-w-full text-sm text-gray-800 bg-white">
                <thead>
                    <tr>
                        <th class="px-2 py-1 text-center text-gray-700 bg-gray-100" rowspan="2">
                            Detalle
                        </th>
                        <th class="px-4 py-2 text-center text-green-800 bg-green-100" colspan="3">
                            Entradas
                        </th>
                        <th class="px-4 py-2 text-center text-red-800 bg-red-100" colspan="3">
                            Salida
                        </th>
                        <th class="px-4 py-2 text-center text-blue-800 bg-blue-100" colspan="3">
                            Balance
                        </th>
                        <th class="px-2 py-1 text-center text-gray-700 bg-gray-100" rowspan="2">
                            fecha
                        </th>
                    </tr>

                    <tr class="text-gray-700">
                        <th class="px-2 py-1 text-center bg-gray-50">
                            Cantidad
                        </th>
                        <th class="px-2 py-1 text-center bg-gray-50">
                            Costo
                        </th>
                        <th class="px-2 py-1 text-center bg-gray-50">
                            Total
                        </th>

                        <th class="px-2 py-1 text-center bg-red-50">
                            Cantidad
                        </th>
                        <th class="px-2 py-1 text-center bg-red-50">
                            Costo
                        </th>
                        <th class="px-2 py-1 text-center bg-red-50">
                            Total
                        </th>

                        <th class="px-2 py-1 text-center bg-blue-50">
                            Cantidad
                        </th>
                        <th class="px-2 py-1 text-center bg-blue-50">
                            Costo
                        </th>
                        <th class="px-2 py-1 text-center bg-blue-50">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory)
                        <tr>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->detail }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->quantity_in }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->cost_in }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->total_in }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->quantity_out }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->cost_out }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->total_out }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->quantity_balance }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->cost_balance }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->total_balance }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $inventory->created_at }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $inventories->links() }}
            </div>
        </div>
    @else
        <x-wire-card>
            <p class="text-lg font-semibold text-center">No hay registros de inventario</p>
            <p class="text-center text-gray-500 text-small">Todavia no se han registrado entradas o salidas de productos
                en el
                almacen seleccionado</p>
        </x-wire-card>
    @endif
</div>
