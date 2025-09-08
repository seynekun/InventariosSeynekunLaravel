<a href="{{ route($route) }}"
    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ $active ? 'bg-gray-100' : '' }}">
    <span class="inline-flex items-center justify-center w-6 h-6 text-gray-500">
        <i class="{{ $icon }}"></i>
    </span>
    <span class="ms-3">{{ $title }}</span>
</a>
