<x-admin-layout title="Transferencias | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Transferencias',
        'href' => route('admin.transfers.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    @livewire('admin.transfer-create')
</x-admin-layout>
