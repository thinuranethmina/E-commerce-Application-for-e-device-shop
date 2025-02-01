<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'image',
        'name',
        'location',
        'comment',
        'rating',
        'status',
    ];
}
