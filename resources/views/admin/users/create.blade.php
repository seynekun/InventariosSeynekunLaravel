<x-admin-layout title="Usuarios | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    <x-wire-card>
        <h1 class="mb-4 text-2xl font-semibold">Nuevo Usuario</h1>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <x-wire-input name="name" placeholder="Nombre del usuario" value="{{ old('name') }}" required />
                <x-wire-input name="email" placeholder="correo electronico del usuario" value="{{ old('email') }}" required />
                <x-wire-input name="password" type="password" placeholder="Contraseña de usuario" required />
                <x-wire-input name="password_confirmation" type="password" placeholder="Confirmar Contraseña"
                    required />
            </div>
            
            <div class="mt-4">
                <x-wire-native-select label="Rol" name="role_id" required>
                    <option value="">Selecciona un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </x-wire-native-select>
            </div>
            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" blue>Crear</x-wire-button>
            </div>
        </form>

    </x-wire-card>

</x-admin-layout>
