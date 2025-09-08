<x-admin-layout title="Ventas | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ventas',
    ],
]">

    @can('create-sales')
        <x-slot name="action">
            <x-wire-button blue href="{{ route('admin.sales.create') }}">Nuevo</x-wire-button>
        </x-slot>
    @endcan

    @livewire('admin.datatables.sale-table')
</x-admin-layout>
