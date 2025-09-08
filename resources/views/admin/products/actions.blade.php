<div class="flex items-center space-x-2">
    @can('read-products')
        <x-wire-button href="{{ route('admin.products.kardex', $product) }}" green xs>
            <i class="fas fa-boxes-stacked"></i>
        </x-wire-button>
    @endcan

    @can('update-products')
        <x-wire-button href="{{ route('admin.products.edit', $product) }}" blue xs>
            <i class="fa fa-edit"></i>
        </x-wire-button>
    @endcan

    @can('delete-products')
        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="delete-form">
            @csrf
            @method('DELETE')
            <x-wire-button type="submit" red xs>
                <i class="fa fa-trash-alt"></i>
            </x-wire-button>
        </form>
    @endcan
</div>
