<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'role', 'department', 'bio', 'photo',
        'email', 'phone', 'linkedin', 'twitter',
        'is_active', 'show_on_site', 'sort_order',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'show_on_site' => 'boolean',
        'sort_order'   => 'integer',
    ];
}
