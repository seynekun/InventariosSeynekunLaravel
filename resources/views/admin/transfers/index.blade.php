<x-admin-layout title="Transferencias | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Transferencias',
    ],
]">
    @can('create-transfers')
        <x-slot name="action">
            <x-wire-button blue href="{{ route('admin.transfers.create') }}">Nuevo</x-wire-button>
        </x-slot>
    @endcan

    @livewire('admin.datatables.transfer-table')
</x-admin-layout>
