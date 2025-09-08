<div class="flex items-center space-x-4">
    @can('read-sales')
        <x-wire-button green wire:click='openModal({{ $sale->id }})'>
            <i class=" fa-solid fa-envelope"></i>
        </x-wire-button>

        <x-wire-button blue href="{{ route('admin.sales.pdf', $sale) }}">
            <i class=" fa-solid fa-file-pdf"></i>
        </x-wire-button>
    @endcan

</div>
