<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\PurchaseOrder;
use Livewire\Component;

class PurchaseOrderCreate extends Component
{
    public $voucher_type = 1;
    public $serie = 'OC01';
    public $correlative;
    public $date;

    public $supplier_id;
    public $total = 0;
    public $observation;

    public $product_id;

    public $products = [];

    public function boot()
    {
        // Verifica si hay errores de validación
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                $html = "<ul class='text-left'>";
                foreach ($errors as  $error) {
                    $html .= "<li class='text-red-500'>{$error[0]}</li>";
                }
                $html .= "</ul>";
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => '!Error de validación!',
                    'html' => $html,
                ]);
            }
        });
    }

    public function mount()
    {
        $this->correlative = PurchaseOrder::max('correlative') + 1;
    }

    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
        ], [], [
            'product_id' => 'Producto'
        ]);

        $existig = collect($this->products)->firstWhere('id', $this->product_id);

        if ($existig) {
            $this->dispatch('swal', [
                'icon' => 'warning',
                'title' => 'Producto Existente',
                'text' => 'El producto ya existe en el pedido',
            ]);
            return;
        }
        $product = Product::find($this->product_id);
        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => 0,
            'subtotal' => 0,
        ];
        $this->reset('product_id');
    }

    public function save()
    {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'date' => 'nullable|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'total' => 'required|numeric|min:0',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:0',
            'products.*.price' => 'required|numeric|min:0',
        ], [], [
            'voucher_type' => 'Tipo de comprobante',
            'supplier_id' => 'Proveedor',
            'total' => 'Total',
            'observation' => 'Observaciones',
            'products.*.id' => 'Producto',
            'products.*.quantity' => 'Cantidad',
            'products.*.price' => 'Precio',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date ?? now(),
            'supplier_id' => $this->supplier_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        foreach ($this->products as $product) {
            $purchaseOrder->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['price'] * $product['quantity'],
            ]);
        }
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Bien Hecho!',
            'text' => 'Order de compra creado con éxito',
        ]);
        return redirect()->route('admin.purchase-orders.index');
    }

    public function render()
    {
        return view('livewire.admin.purchase-order-create');
    }
}
