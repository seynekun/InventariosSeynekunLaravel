<x-admin-layout title="Clientes | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Clientes',
        'href' => route('admin.customers.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">
    <x-wire-card>
        <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <x-wire-native-select label="Tipo de documento" name="identity_id">
                    @foreach ($identities as $identity)
                        <option value="{{ $identity->id }}" @selected(old('identity_id') == $identity->id)>{{ $identity->name }}</option>
                    @endforeach
                </x-wire-native-select>

                <x-wire-input label="Num Doc" name="document_number" placeholder="Número de documento"
                    value="{{ old('document_number') }}" />
            </div>
            <x-wire-input label="Nombre" name="name" placeholder="Nombre del cliente" value="{{ old('name') }}" />
            <x-wire-input label='dirección' name="address" placeholder="Dirección del cliente"
                value="{{ old('address') }}" />
            <x-wire-input label="Correo" name="email" placeholder="Correo electrónico del cliente"
                value="{{ old('email') }}" />
            <x-wire-input label="Telefono" name="phone" placeholder="Teléfono del cliente"
                value="{{ old('phone') }}" />
            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>
