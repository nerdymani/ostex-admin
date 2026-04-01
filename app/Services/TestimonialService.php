<?php

namespace App\Services;

use App\Models\Testimonial;

class TestimonialService
{
    public function getApproved(): \Illuminate\Database\Eloquent\Collection
    {
        return Testimonial::where('is_approved', true)->orderBy('sort_order')->get();
    }

    public function getFeatured(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return Testimonial::where('is_approved', true)->where('is_featured', true)
            ->orderBy('sort_order')->limit($limit)->get();
    }
}
