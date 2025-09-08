<div
    class="min-h-screen flex flex-col sm:justify-center items-center bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300">
    <!-- Logo -->
    <div>
        {{ $logo }}
    </div>

    <!-- Card -->
    <div class="w-full sm:max-w-md px-6 py-8 bg-white/80 backdrop-blur-md shadow-xl rounded-2xl border border-gray-200">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <div class="mt-6 text-center text-sm text-gray-500">
        © {{ date('Y') }} <span class="font-semibold">{{ config('app.name') }}</span>. Todos los derechos reservados.
    </div>
</div>
