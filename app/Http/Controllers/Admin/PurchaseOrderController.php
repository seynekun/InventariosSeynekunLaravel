<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        Gate::authorize('read-purchase-orders');
        return view('admin.purchase-orders.index');
    }

    public function create()
    {
        Gate::authorize('create-purchase-orders');
        return view('admin.purchase-orders.create');
    }
    public function pdf(PurchaseOrder $purchaseOrder)
    {
        Gate::authorize('read-purchase-orders');
        $pdf = Pdf::loadView('admin.purchase-orders.pdf', [
            'model' => $purchaseOrder
        ]);
        return $pdf->download("order_compra-{$purchaseOrder->id}.pdf");
    }
}
