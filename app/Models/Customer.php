<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'identity_id',
        'document_number',
        'name',
        'address',
        'email',
        'phone',
    ];

    //Relación uno a muchos inversa
    public function identity()
    {
        return $this->belongsTo(Identity::class);
    }

    //Relación uno a muchos
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
