<x-admin-layout title="Categorias | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorias',
    ],
]">
    @can('create-categories')
        <x-slot name="action">
            <x-wire-button green href="{{ route('admin.categories.import') }}">
                <i class="fas fa-file-import"></i>
                Importar</x-wire-button>
            <x-wire-button blue href="{{ route('admin.categories.create') }}">
                <i class="fas fa-plus"></i>
                Nuevo</x-wire-button>
        </x-slot>
    @endcan
    @livewire('admin.datatables.category-table')
</x-admin-layout>
