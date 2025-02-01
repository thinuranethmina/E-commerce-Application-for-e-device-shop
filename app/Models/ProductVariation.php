<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'stock',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function values()
    {
        return $this->hasMany(ProductVariationValue::class, 'product_variation_id', 'id');
    }

    public function valueFor($key)
    {
        return ProductVariationValue::where('product_variation_id', $this->id)->whereIn('variation_value_id', VariationValues::where('variations_id', $key)->pluck('id'))->first();
    }
}
