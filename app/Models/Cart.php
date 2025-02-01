<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'session_id',
        'product_variation_id',
        'qty',
    ];

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id', 'id');
    }
}
