<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas principales
        $totalSales = Sale::whereMonth('date', now()->month)
                         ->whereYear('date', now()->year)
                         ->sum('total');
        
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $lowStockProducts = Product::where('stock', '<=', 10)->count();

        // Datos para gráficas
        // Ventas por mes del año actual
        $monthlySales = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlySales[] = Sale::whereMonth('date', $i)
                                ->whereYear('date', now()->year)
                                ->sum('total');
        }

        // Datos del inventario para gráfica de dona
        $stockNormal = Product::where('stock', '>', 10)->count();
        $stockBajo = Product::where('stock', '>', 0)->where('stock', '<=', 10)->count();
        $sinStock = Product::where('stock', '=', 0)->count();

        return view('admin.dashboard', compact(
            'totalSales',
            'totalProducts', 
            'totalCustomers',
            'lowStockProducts',
            'monthlySales',
            'stockNormal',
            'stockBajo',
            'sinStock'
        ));
    }
}