<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'price', 'price_label', 'billing_cycle',
        'description', 'features', 'is_featured', 'is_active',
        'sort_order', 'cta_label', 'cta_url',
    ];

    protected $casts = [
        'features'    => 'array',
        'price'       => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
    ];
}
