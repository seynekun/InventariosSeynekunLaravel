<x-admin-layout title="Roles | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
        'href' => route('admin.roles.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    <x-wire-card>
        <h1 class="mb-4 text-2xl font-semibold">Nuevo Rol</h1>
        <form class="space-y-4" action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <x-wire-input label="Nombre de Rol" name="name" placeholder="Nombre del rol" placeholder="Ej: Administrador"
                required value="{{ old('name') }}" />

            <div>
                <p class="mb-2 font-semibold text-gray-600">Permisos</p>
                <ul class="gap-4 columns-1 md:columns-2 lg:columns-4">
                    @foreach ($permissions as $permission)
                        <li>
                            <label>
                                <x-checkbox name="permissions[]" value="{{ $permission->id }}" :checked="in_array($permission->id, old('permissions', []))" />
                                <span class="text-sm text-gray-700">
                                    {{ $permission->name }}
                                </span>
                            </label>
                        </li>
                    @endforeach
                </ul>


            </div>

            <div class="flex justify-end">
                <x-wire-button type="submit" blue>Crear Rol</x-wire-button>
            </div>

        </form>
    </x-wire-card>

</x-admin-layout>
