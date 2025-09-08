<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'voucher_type',
        'serie',
        'correlative',
        'date',
        'customer_id',
        'total',
        'observation',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    //Relación uno a muchos inversa
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    //Relación muchos a muchos polimórfica
    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')
            ->withPivot('quantity', 'price', 'subtotal')
            ->withTimestamps();
    }
}
