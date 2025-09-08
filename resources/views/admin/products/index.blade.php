<x-admin-layout title="Productos | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Productos',
    ],
]">
    @push('css')
        <style>
            table th span,
            table td {
                font-size: 0.75rem !important;
            }

            .image-product {
                width: 5rem;
                height: 3rem;
                object-fit: cover;
                object-position: center;
            }
        </style>
    @endpush

    @can('create-products')
        <x-slot name="action">
            <x-wire-button green href="{{ route('admin.products.import') }}">
                <i class="fas fa-file-import"></i>
                Importar</x-wire-button>
            <x-wire-button blue href="{{ route('admin.products.create') }}">
                <i class="fas fa-plus"></i>
                Nuevo</x-wire-button>
        </x-slot>
    @endcan
    @livewire('admin.datatables.product-table')
</x-admin-layout>
