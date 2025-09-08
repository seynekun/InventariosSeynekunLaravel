<x-admin-layout title="Entradas y salidas | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Entradas y salidad',
        'href' => route('admin.movements.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    @livewire('admin.movement-create')
</x-admin-layout>
