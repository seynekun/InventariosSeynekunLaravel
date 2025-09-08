<x-admin-layout title="Categorias | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Importar',
    ],
]">

    @livewire('admin.import-of-categories')

</x-admin-layout>
