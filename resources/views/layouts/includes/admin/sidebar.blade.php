@php
    use App\Services\Menu\MenuHeader;
    use App\Services\Menu\MenuLink;
    use App\Services\Menu\MenuGroup;

    // Grupo Inventario
    $inventarioGroup = new MenuGroup(
        title: 'Inventarios',
        icon: 'fa-solid fa-boxes-stacked',
        active: request()->routeIs(['admin.categories.*', 'admin.products.*', 'admin.warehouses.*']),
    );
    $inventarioGroup
        ->addItem(
            'Categorias',
            'fa-regular fa-circle',
            'admin.categories.index',
            request()->routeIs('admin.categories.*'),
        )
        ->addItem('Productos', 'fa-regular fa-circle', 'admin.products.index', request()->routeIs('admin.products.*'))
        ->addItem(
            'Almacenes',
            'fa-regular fa-circle',
            'admin.warehouses.index',
            request()->routeIs('admin.warehouses.*'),
        );

    // Grupo Compras
    $comprasGroup = new MenuGroup(
        title: 'Compras',
        icon: 'fa-solid fa-shopping-cart',
        active: request()->routeIs(['admin.suppliers.*', 'admin.purchase-orders.*', 'admin.purchases.*']),
    );
    $comprasGroup
        ->addItem(
            'Proveedores',
            'fa-regular fa-circle',
            'admin.suppliers.index',
            request()->routeIs('admin.suppliers.*'),
        )
        ->addItem(
            'Ordenes de Compra',
            'fa-regular fa-circle',
            'admin.purchase-orders.index',
            request()->routeIs('admin.purchase-orders.*'),
        )
        ->addItem('Compras', 'fa-regular fa-circle', 'admin.purchases.index', request()->routeIs('admin.purchases.*'));

    // Grupo Ventas
    $ventasGroup = new MenuGroup(
        title: 'Ventas',
        icon: 'fa-solid fa-store',
        active: request()->routeIs(['admin.customers.*', 'admin.quotes.*', 'admin.sales.*']),
    );
    $ventasGroup
        ->addItem('Clientes', 'fa-regular fa-circle', 'admin.customers.index', request()->routeIs('admin.customers.*'))
        ->addItem('Cotizaciones', 'fa-regular fa-circle', 'admin.quotes.index', request()->routeIs('admin.quotes.*'))
        ->addItem('Ventas', 'fa-regular fa-circle', 'admin.sales.index', request()->routeIs('admin.sales.*'));

    // Grupo Movimientos
    $movimientosGroup = new MenuGroup(
        title: 'Movimientos',
        icon: 'fa-solid fa-truck-moving',
        active: request()->routeIs(['admin.movements.*', 'admin.transfers.*']),
    );
    $movimientosGroup
        ->addItem(
            'Entradas y Salidas',
            'fa-regular fa-circle',
            'admin.movements.index',
            request()->routeIs('admin.movements.*'),
        )
        ->addItem(
            'Transferencias',
            'fa-regular fa-circle',
            'admin.transfers.index',
            request()->routeIs('admin.transfers.*'),
        );

    // Grupo Reportes
    $reportesGroup = new MenuGroup(
        title: 'Reportes',
        icon: 'fa-solid fa-file',
        active: request()->routeIs([
            'admin.reports.top-products',
            'admin.reports.low-stock',
            'admin.reports.top-customers',
        ]),
    );
    $reportesGroup
        ->addItem(
            'Productos Top',
            'fa-regular fa-circle',
            'admin.reports.top-products',
            request()->routeIs('admin.reports.top-products'),
        )
        ->addItem(
            'Clientes frecuentes',
            'fa-regular fa-circle',
            'admin.reports.top-customers',
            request()->routeIs('admin.reports.top-customers'),
        )
        ->addItem(
            'Stock',
            'fa-regular fa-circle',
            'admin.reports.low-stock',
            request()->routeIs('admin.reports.low-stock'),
        );

    // Grupo Configuración
    $configuracionLinks = [
        new MenuHeader('Configuración'),
        new MenuLink('Usuarios', 'fa-solid fa-user', 'admin.users.index', request()->routeIs('admin.users.*')),
        new MenuLink('Roles', 'fa-solid fa-user-group', 'admin.roles.index', request()->routeIs('admin.roles.*')),
        // new MenuLink(
        //     'Permisos',
        //     'fa-solid fa-lock',
        //     'admin.permissions.index',
        //     request()->routeIs('admin.permissions.*'),
        // ),
        // new MenuLink('Ajustes', 'fa-solid fa-gear', 'admin.settings.index', request()->routeIs('admin.settings.*')),
    ];

    // Menú completo
    $links = [
        new MenuHeader('Principal'),
        new MenuLink('Dashboard', 'fa-solid fa-gauge', 'admin.dashboard', request()->routeIs('admin.dashboard')),
        $inventarioGroup,
        $comprasGroup,
        $ventasGroup,
        $movimientosGroup,
        $reportesGroup,
    ];

    $links = array_merge($links, $configuracionLinks);
@endphp

<div>
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium">
                @foreach ($links as $link)
                    <li>{!! $link->render() !!}</li>
                @endforeach
            </ul>
        </div>
    </aside>
</div>
