<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'brand_id',
        'sub_category_id',
        'is_featured',
        'thumbnail',
        'warranty_period',
        'warranty_info',
        'name',
        'description',
        'status',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id', 'id');
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'product_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    public function startingPrice()
    {
        return ProductVariation::where('product_id', $this->id)->min('price') ?? 0;
    }

    public function totalStock()
    {
        return ProductVariation::where('product_id', $this->id)->sum('stock') ?? 0;
    }
    public function reviewRate()
    {
        return number_format(
            round(Review::where('product_id', $this->id)
                ->where('status', 'Active')
                ->avg('rating') ?? 0, 1),
            1
        );
    }
    public function attributes()
    {
        return Variation::whereIn(
            'id',
            VariationValues::whereIn(
                'id',
                ProductVariationValue::whereIn(
                    'product_variation_id',
                    ProductVariation::where('product_id', $this->id)->pluck('id')
                )->pluck('variation_value_id')
            )->pluck('variations_id')
        )->get();
    }

    public function attributeValues($id)
    {
        return VariationValues::where('variations_id', $id)
            ->whereIn(
                'id',
                ProductVariationValue::query()
                    ->whereIn(
                        'product_variation_id',
                        ProductVariation::query()
                            ->where('product_id', $this->id)
                            ->pluck('id')
                    )
                    ->pluck('variation_value_id')
            )
            ->get();
    }
}
