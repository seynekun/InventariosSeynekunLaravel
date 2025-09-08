<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Product;

class KardexService
{
    public function getLastRecord($productId, $warehouseId)
    {
        $lastRecord = Inventory::where('product_id', $productId)->where('warehouse_id', $warehouseId)->latest('id')->first();

        return [
            'quantity' =>  $lastRecord?->quantity_balance ?? 0,
            'cost' =>  $lastRecord?->cost_balance ?? 0,
            'total' =>  $lastRecord?->total_balance ?? 0,
            'date' =>  $lastRecord?->created_at ?? null,
        ];
    }

    public function registerEntry($model, array $product, $warehouseId, $detail)
    {
        $lastRecord = $this->getlastRecord($product['id'], $warehouseId);
        $newQuantityBalance = $lastRecord['quantity'] + $product['quantity'];
        $newTotalBalance = $lastRecord['total'] + ($product['quantity'] * $product['price']);
        $newCostBalance = $newTotalBalance / $newQuantityBalance;

        $model->inventories()->create([
            'detail' => $detail,
            'quantity_in' => $product['quantity'],
            'cost_in' => $product['price'],
            'total_in' => $product['price'] * $product['quantity'],
            'quantity_balance' => $newQuantityBalance,
            'cost_balance' => $newCostBalance,
            'total_balance' => $newTotalBalance,
            'product_id' => $product['id'],
            'warehouse_id' => $warehouseId,
        ]);
        Product::where('id', $product['id'])->increment('stock', $product['quantity']);
    }

    public function registerExit($model, array $product, $warehouseId, $detail)
    {
        $lastRecord = $this->getlastRecord($product['id'], $warehouseId);
        $newQuantityBalance = $lastRecord['quantity'] - $product['quantity'];
        $newTotalBalance = $lastRecord['total'] - ($product['quantity'] * $lastRecord['cost']);
        $newCostBalance = $newTotalBalance / ($newQuantityBalance ?: 1);

        $model->inventories()->create([
            'detail' => $detail,
            'quantity_out' => $product['quantity'],
            'cost_out' => $lastRecord['cost'],
            'total_out' => $product['quantity'] * $lastRecord['cost'],
            'quantity_balance' => $newQuantityBalance,
            'cost_balance' => $newCostBalance,
            'total_balance' => $newTotalBalance,
            'product_id' => $product['id'],
            'warehouse_id' => $warehouseId,
        ]);
        Product::where('id', $product['id'])->decrement('stock', $product['quantity']);
    }
}
