<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'icon',
        'slug',
        'name',
        'status',
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
}
