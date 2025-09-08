@props([
    'title' => config('app.name', 'Laravel'),
    'breadcrumbs' => [],
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/c58b4d7ca8.js" crossorigin="anonymous"></script>

    {{-- Sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Wireui --}}
    <wireui:scripts />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    @livewireStyles
    @stack('css')
</head>

<body class="font-sans antialiased bg-gray-50">
    @include('layouts.includes.admin.navigation')

    @include('layouts.includes.admin.sidebar')
    <div class="p-4 sm:ml-64">
        <div class="flex items-center mt-14">
            @include('layouts.includes.admin.breadcrumb')
            @isset($action)
                <div class="ml-auto">{{ $action }}</div>
            @endisset
        </div>
        {{ $slot }}
    </div>

    @stack('modals')

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <script>
        Livewire.on('swal', (data) => {
            Swal.fire(data[0]);
        })
    </script>

    @if (session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif
    <script>
        forms = document.querySelectorAll(".delete-form")
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Estas seguro?",
                    text: "No podras revertir esta acción",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            })
        });
    </script>
    @stack('js')
</body>

</html>
