<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'company', 'subject',
        'message', 'type', 'status', 'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];
}
