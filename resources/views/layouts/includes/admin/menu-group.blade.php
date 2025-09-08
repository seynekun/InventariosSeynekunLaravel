<div x-data="{
    open: {{ $active ? 'true' : 'false' }}
}">
    <button type="button" @click="open = !open"
        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 ">
        <span class="inline-flex items-center justify-center w-6 h-6 text-gray-500">
            <i class="{{ $icon }}"></i>
        </span>
        <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">{{ $title }}</span>

        <i class="text-sm"
            :class="{
                'fa-solid fa-chevron-up': open,
                'fa-solid fa-chevron-down': !open
            }"></i>
    </button>
    <ul x-show="open" x-cloak class="py-2 space-y-2">
        @foreach ($items as $item)
            <li class="pl-2">
                {!! $item->render() !!}
            </li>
        @endforeach
    </ul>
</div>
