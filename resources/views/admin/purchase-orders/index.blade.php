<x-admin-layout title="Ordenes de Compra | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ordenes de Compra',
    ],
]">

    @can('create-purchase-orders')
        <x-slot name="action">
            <x-wire-button blue href="{{ route('admin.purchase-orders.create') }}">Nuevo</x-wire-button>
        </x-slot>
    @endcan

    @livewire('admin.datatables.purchase-order-table')
</x-admin-layout>
