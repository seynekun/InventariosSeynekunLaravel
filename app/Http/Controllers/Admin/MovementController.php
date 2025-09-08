<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MovementController extends Controller
{
    public function index()
    {
        Gate::authorize('read-movements');
        return view('admin.movements.index');
    }

    public function create()
    {
        Gate::authorize('create-movements');
        return view('admin.movements.create');
    }

    public function pdf(Movement $movement)
    {
        Gate::authorize('read-movements');
        $pdf = Pdf::loadView('admin.movements.pdf', [
            'model' => $movement
        ]);
        return $pdf->download("Movimiento-{$movement->id}.pdf");
    }
}
