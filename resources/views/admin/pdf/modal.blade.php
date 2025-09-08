<x-wire-modal-card wire:model='form.open' width="lg">

    <p class="mb-2 text-xl text-center">
        Enviar Email
    </p>

    <p class="mb-2 text-lg text-center uppercase">
        Documento: {{ $form['document'] }}
    </p>
    <p class="mb-2 text-center uppercase">
        Cliente: {{ $form['client'] }}
    </p>
    <form wire:submit='sendEmail'>
        <x-wire-input label="Correo electrónico" wire:model='form.email' class="mb-4" />
        <x-wire-button type="submit" class="w-full">Enviar Correo</x-wire-button>
    </form>
</x-wire-modal-card>
