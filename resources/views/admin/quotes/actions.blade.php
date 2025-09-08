<div class="flex items-center space-x-4">
    @can('read-quotes')
        <x-wire-button green wire:click='openModal({{ $quote->id }})'>
            <i class=" fa-solid fa-envelope"></i>
        </x-wire-button>

        <x-wire-button blue href="{{ route('admin.quotes.pdf', $quote) }}">
            <i class=" fa-solid fa-file-pdf"></i>
        </x-wire-button>
    @endcan

</div>
