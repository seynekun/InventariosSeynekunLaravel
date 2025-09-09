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
        'name' => 'Editar',
    ],
]">
    <x-wire-card>
        <h1 class="mb-4 text-2xl font-semibold">Editar Usuario</h1>
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <x-wire-input name="name" placeholder="Nombre del usuario" value="{{ old('name', $user->name) }}" required />
                <x-wire-input name="email" placeholder="correo electronico del usuario"
                    value="{{ old('email', $user->email) }}" required />
                <x-wire-input name="password" type="password" placeholder="Contraseña de usuario (dejar vacío para mantener actual)" />
                <x-wire-input name="password_confirmation" type="password" placeholder="Confirmar Contraseña" />
            </div>
            
            <div class="mt-4">
                <x-wire-native-select label="Rol" name="role_id" required>
                    <option value="">Selecciona un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id', $user->roles->first()?->id) == $role->id)>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </x-wire-native-select>
            </div>
            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" blue>Actualizar</x-wire-button>
            </div>
        </form>

    </x-wire-card>

</x-admin-layout>
