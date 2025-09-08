<x-admin-layout title="Proveedores | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Proveedores',
        'href' => route('admin.suppliers.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">
    <x-wire-card>
        <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <x-wire-native-select label="Tipo de documento" name="identity_id">
                    @foreach ($identities as $identity)
                        <option value="{{ $identity->id }}" @selected(old('identity_id', $supplier->identity_id) == $identity->id)>{{ $identity->name }}</option>
                    @endforeach
                </x-wire-native-select>

                <x-wire-input label="Num Doc" name="document_number" placeholder="Número de documento"
                    value="{{ old('document_number', $supplier->document_number) }}" />
            </div>
            <x-wire-input label="Nombre" name="name" placeholder="Nombre del proveedor"
                value="{{ old('name', $supplier->name) }}" />
            <x-wire-input label='dirección' name="address" placeholder="Dirección del proveedor"
                value="{{ old('address', $supplier->address) }}" />
            <x-wire-input label="Correo" name="email" placeholder="Correo electrónico del proveedor"
                value="{{ old('email', $supplier->email) }}" />
            <x-wire-input label="Telefono" name="phone" placeholder="Teléfono del proveedor"
                value="{{ old('phone', $supplier->phone) }}" />
            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>
