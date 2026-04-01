<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'role', 'company', 'message', 'photo',
        'rating', 'is_approved', 'is_featured', 'sort_order',
    ];

    protected $casts = [
        'rating'      => 'integer',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order'  => 'integer',
    ];
}
