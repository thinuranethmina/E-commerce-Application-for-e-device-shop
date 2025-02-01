<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariationValue extends Model
{
    protected $fillable = [
        'product_variation_id',
        'variation_value_id',
    ];

    public function variationValue()
    {
        return $this->belongsTo(VariationValues::class, 'variation_value_id', 'id');
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id', 'id');
    }
}
