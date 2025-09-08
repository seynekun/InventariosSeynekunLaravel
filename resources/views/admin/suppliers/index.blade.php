<x-admin-layout title="Proveedores | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Proveedores',
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
    @can('create-suppliers')
        <x-slot name="action">
            <x-wire-button blue href="{{ route('admin.suppliers.create') }}">Nuevo</x-wire-button>
        </x-slot>
    @endcan
    @livewire('admin.datatables.supplier-table')
</x-admin-layout>
