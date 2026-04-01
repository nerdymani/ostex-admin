<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'image', 'category',
        'alt_text', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];
}
