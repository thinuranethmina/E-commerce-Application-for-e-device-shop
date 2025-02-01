<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationValues extends Model
{
    protected $fillable = [
        'variations_id',
        'variable',
        'color',
    ];

    public function variationName()
    {
        return $this->belongsTo(Variation::class, 'variations_id', 'id');
    }
    public function allValues()
    {
        return VariationValues::where('variations_id', $this->variations_id)->get();
    }
}
