<?php

namespace App\Services;

use App\Models\Faq;

class FaqService
{
    public function getAllGrouped(): array
    {
        return Faq::where('is_active', true)->orderBy('sort_order')->get()
            ->groupBy('category')->toArray();
    }

    public function getByCategory(string $category): \Illuminate\Database\Eloquent\Collection
    {
        return Faq::where('is_active', true)->where('category', $category)->orderBy('sort_order')->get();
    }
}
