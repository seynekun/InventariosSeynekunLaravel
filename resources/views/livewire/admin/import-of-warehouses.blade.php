<div>
    <x-wire-card>
        <h1 class="mb-6 text-2xl font-semibold text-gray-800">
            Importar Almacenes desde excel
        </h1>

        <x-wire-button blue wire:click="downloadTemplate">
            <i class="fas fa-file-excel"></i>
            Descargar plantilla
        </x-wire-button>
        <p class="mt-1 text-sm text-gray-500">Completa la plantilla con los datos y subela para importar</p>

        <div class="mt-4">
            <input type="file" accept=".xlsx, .xls" wire:model="file" />
            <x-input-error for="file" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-wire-button green wire:click="importWarehouses" wire:loading.attr="disabled" wire:target="file"
                spinner="importWarehouses">
                <i class="mr-2 fas fa-upload"></i>
                Importar Almacenes
            </x-wire-button>
        </div>
        @if (count($errors) > 0)
            <div class="mt-4">
                <div class="p-4 mb-3 text-yellow-800 bg-yellow-100 border border-yellow-300 rounded-md">
                    @if ($importedCount)
                        <i class="mr-2 fas fa-triangle-exclamation"></i>
                        <strong>Importación completada parcialmente</strong>
                        <p class="mt-1 text-sm">
                            Algunos almacenes no se pudieron importar debido a errores
                        </p>
                    @else
                        <i class="mr-2 fas fa-xmark"></i>
                        <strong>No se importo ningun almacen</strong>
                        <p class="mt-1 text-sm">Todos los almacenes tienen errores o el archivo no es valido</p>
                    @endif
                </div>
                <ul class="space-y-2">
                    @foreach ($errors as $error)
                        <li class="p-3 text-red-800 border-red-200 rounded-md bg-red-50">
                            <p class="font-semibold text-red-700">
                                <i class="fas fa-file-pen"></i>
                                <strong>Fila {{ $error['row'] }};</strong>
                            </p>
                            <ul class="mt-1 list-disc list-inside">
                                @foreach ($error['errors'] as $error)
                                    <li class="text-sm text-red-600">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>

        @endif
    </x-wire-card>

</div>
