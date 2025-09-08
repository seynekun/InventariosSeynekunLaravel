<x-admin-layout title="Dashboard | Inventario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
]">
    <x-slot name="action">
        <div class="flex space-x-2">
            <x-wire-button blue href="{{ route('admin.sales.create') }}">Nueva Venta</x-wire-button>
            <x-wire-button green href="{{ route('admin.purchases.create') }}">Nueva Compra</x-wire-button>
        </div>
    </x-slot>

    <!-- Estadísticas principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ventas del Mes</p>
                    <p class="text-2xl font-bold text-gray-900">COP {{ number_format($totalSales, 0, ',', '.') }}</p>
                    <p class="text-xs text-green-600 mt-1">+12% vs mes anterior</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Productos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                    <p class="text-xs text-gray-500 mt-1">En inventario</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Clientes Activos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalCustomers }}</p>
                    <p class="text-xs text-gray-500 mt-1">Este mes</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Stock Bajo</p>
                    <p class="text-2xl font-bold text-red-600">{{ $lowStockProducts }}</p>
                    <p class="text-xs text-red-500 mt-1">Productos críticos</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficas básicas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Gráfica de Ventas Mensuales -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Ventas del Año</h3>
            <div style="height: 300px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Gráfica de Productos por Stock -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Estado del Inventario</h3>
            <div style="height: 300px;">
                <canvas id="inventoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Scripts para las gráficas -->
    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gráfica de ventas mensuales
            new Chart(document.getElementById('salesChart'), {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Ventas (COP)',
                        data: [{{ implode(',', $monthlySales) }}],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Ventas: $' + new Intl.NumberFormat('es-CO').format(context.parsed.y) + ' COP';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + new Intl.NumberFormat('es-CO').format(value);
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Gráfica de inventario
            new Chart(document.getElementById('inventoryChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Stock Normal', 'Stock Bajo', 'Sin Stock'],
                    datasets: [{
                        data: [{{ $stockNormal }}, {{ $stockBajo }}, {{ $sinStock }}],
                        backgroundColor: [
                            '#10B981',
                            '#F59E0B', 
                            '#EF4444'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush

</x-admin-layout>
