<x-admin-layout title="Compras | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Compras',
    ],
]">

    @can('create-purchases')
        <x-slot name="action">
            <x-wire-button blue href="{{ route('admin.purchases.create') }}">Nuevo</x-wire-button>
        </x-slot>
    @endcan

    @livewire('admin.datatables.purchase-table')
</x-admin-layout>
