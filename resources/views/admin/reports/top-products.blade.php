<x-admin-layout title="Reportes | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Productos Mas vendidos',
    ],
]">


    @livewire('admin.datatables.top-products-table')

</x-admin-layout>
