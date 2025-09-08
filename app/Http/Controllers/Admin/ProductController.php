<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read-products');
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create-products');
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-products');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        $product = Product::create($data);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Producto creado exitosamente',
            'text' => 'El producto ha sido creado exitosamente',
        ]);
        return redirect()->route('admin.products.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        Gate::authorize('update-products');
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        Gate::authorize('update-products');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        $product->update($data);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Bien Hecho!',
            'text' => 'El producto ha sido actualizado exitosamente',
        ]);
        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('delete-products');
        if ($product->inventories()->exists()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'El producto no puede eliminarse porque tiene inventarios asociados',
            ]);
            return redirect()->route('admin.products.index');
        }
        if ($product->purchaseOrders()->exists()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'El producto no puede eliminarse porque ordenes de compra o cotizaciones asociadas',
            ]);
            return redirect()->route('admin.products.index');
        }
        $product->delete();
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Bien Hecho!',
            'text' => 'El producto ha sido eliminado exitosamente',
        ]);
        return redirect()->route('admin.products.index');
    }
    public function dropzone(Request $request, Product $product)
    {
        Gate::authorize('update-products');
        $image = $product->images()->create([
            'path' => Storage::put('/images', $request->file('file')),
            'size' => $request->file('file')->getSize(),
        ]);
        return response()->json([
            'id' => $image->id,
            'path' => $image->path,
        ]);
    }
    public function kardex(Product $product)
    {
        Gate::authorize('read-products');
        return view('admin.products.kardex', compact('product'));
    }

    public function import()
    {
        Gate::authorize('create-products');
        return view('admin.products.import');
    }
}
