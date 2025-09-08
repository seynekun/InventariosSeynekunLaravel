<x-admin-layout title="Ventas | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ventas',
        'href' => route('admin.purchases.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    @livewire('admin.sale-create')
</x-admin-layout>
