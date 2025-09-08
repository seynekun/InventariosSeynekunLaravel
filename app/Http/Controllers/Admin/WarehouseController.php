<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read-warehouses');
        return view('admin.warehouses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create-warehouses');
        return view('admin.warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-warehouses');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        $warehouse = Warehouse::create($data);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Bien Hecho!',
            'text' => 'El almacen ha sido creado exitosamente',
        ]);
        return redirect()->route('admin.warehouses.edit', $warehouse);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        Gate::authorize('update-warehouses');
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        Gate::authorize('update-warehouses');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        $warehouse->update($data);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Bien Hecho!',
            'text' => 'El almacen ha sido actualizado exitosamente',
        ]);
        return redirect()->route('admin.warehouses.edit', $warehouse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        Gate::authorize('delete-warehouses');
        if ($warehouse->inventories()->exists()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'El almacen no puede eliminarse porque tiene inventarios asociados',
            ]);
            return redirect()->route('admin.warehouses.index');
        }
        $warehouse->delete();
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Bien Hecho!',
            'text' => 'El almacen ha sido eliminado exitosamente',
        ]);
        return redirect()->route('admin.warehouses.index');
    }

    public function import()
    {
        Gate::authorize('create-warehouses');
        return view('admin.warehouses.import');
    }
}
