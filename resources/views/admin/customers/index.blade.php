<x-admin-layout title="Clientes | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Clientes',
    ],
]">
    @push('css')
        <style>
            table th span,
            table td {
                font-size: 0.75rem !important;
            }
        </style>
    @endpush
    @can('create-customers')
        <x-slot name="action">
            <x-wire-button blue href="{{ route('admin.customers.create') }}">Nuevo</x-wire-button>
        </x-slot>
    @endcan
    @livewire('admin.datatables.customer-table')
</x-admin-layout>
