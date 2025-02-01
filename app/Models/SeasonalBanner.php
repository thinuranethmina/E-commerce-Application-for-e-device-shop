<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonalBanner extends Model
{
    /** @use HasFactory<\Database\Factories\SeasonalBannerFactory> */
    use HasFactory;

    protected $fillable = [
        'image',
        'label1',
        'label2',
        'label3',
        'url',
        'status',
    ];
}
