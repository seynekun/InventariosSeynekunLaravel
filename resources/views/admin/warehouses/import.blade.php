<x-admin-layout title="Almacenes | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Importar',
    ],
]">

    @livewire('admin.import-of-warehouses')

</x-admin-layout>
