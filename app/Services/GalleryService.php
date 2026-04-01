<?php

namespace App\Services;

use App\Models\GalleryItem;

class GalleryService
{
    public function getActive(?string $category = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = GalleryItem::where('is_active', true)->orderBy('sort_order');
        if ($category) $query->where('category', $category);
        return $query->get();
    }

    public function getCategories(): array
    {
        return GalleryItem::where('is_active', true)->distinct()->pluck('category')->filter()->values()->toArray();
    }
}
