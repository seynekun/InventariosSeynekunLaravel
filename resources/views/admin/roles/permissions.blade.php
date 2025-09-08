<div class="flex flex-wrap gap-1">
    @forelse ($permissions as $permission)
        <x-wire-badge>{{ $permission->name }}</x-wire-badge>
    @empty
        <x-wire-badge secondary>Sin permisos</x-wire-badge>
    @endforelse
</div>
