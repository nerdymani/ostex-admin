<?php

namespace App\Services;

use App\Models\Service;

class ServiceService
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Service::where('is_active', true)->orderBy('sort_order')->get();
    }

    public function getFeatured(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return Service::where('is_active', true)->where('is_featured', true)
            ->orderBy('sort_order')->limit($limit)->get();
    }

    public function getBySlug(string $slug): ?Service
    {
        return Service::where('slug', $slug)->where('is_active', true)->first();
    }

    public function getCategories(): array
    {
        return Service::where('is_active', true)->distinct()->pluck('category')->filter()->values()->toArray();
    }
}
