<x-admin-layout title="Entradas y Salidas | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Entradas y Salidas',
    ],
]">
    @can('create-movements')
        <x-slot name="action">
            <x-wire-button blue href="{{ route('admin.movements.create') }}">Nuevo</x-wire-button>
        </x-slot>
    @endcan

    @livewire('admin.datatables.movement-table')
</x-admin-layout>
