<?php

namespace App\Services;

use App\Models\PortfolioItem;
use Illuminate\Pagination\LengthAwarePaginator;

class PortfolioService
{
    public function getPaginated(?string $category = null, int $perPage = 9): LengthAwarePaginator
    {
        $query = PortfolioItem::where('is_active', true)->orderBy('sort_order');
        if ($category) $query->where('category', $category);
        return $query->paginate($perPage);
    }

    public function getFeatured(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return PortfolioItem::where('is_active', true)->where('is_featured', true)
            ->orderBy('sort_order')->limit($limit)->get();
    }

    public function getBySlug(string $slug): ?PortfolioItem
    {
        return PortfolioItem::where('slug', $slug)->where('is_active', true)->first();
    }

    public function getCategories(): array
    {
        return PortfolioItem::where('is_active', true)->distinct()->pluck('category')->filter()->values()->toArray();
    }
}
