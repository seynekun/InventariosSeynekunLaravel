<x-admin-layout title="Roles | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
    ],
]">

    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.roles.create') }}">Nuevo</x-wire-button>
    </x-slot>

    @livewire('admin.datatables.role-table')
</x-admin-layout>
