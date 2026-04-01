<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PortfolioItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'body', 'client',
        'category', 'image', 'gallery', 'technologies',
        'project_url', 'is_active', 'is_featured',
        'sort_order', 'completed_at',
    ];

    protected $casts = [
        'gallery'      => 'array',
        'technologies' => 'array',
        'is_active'    => 'boolean',
        'is_featured'  => 'boolean',
        'sort_order'   => 'integer',
        'completed_at' => 'date',
    ];
}
