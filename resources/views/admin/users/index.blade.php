<x-admin-layout title="Usuarios | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
    ],
]">
    @can('create-users')
        <x-slot name="action">
            <x-wire-button blue href="{{ route('admin.users.create') }}">
                <i class="fas fa-plus"></i>
                Nuevo</x-wire-button>
        </x-slot>
    @endcan
    @livewire('admin.datatables.user-table')
</x-admin-layout>
