<?php

namespace App\Services;

use App\Models\BlogPost;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogService
{
    public function getPaginated(int $perPage = 9, ?string $category = null): LengthAwarePaginator
    {
        $query = BlogPost::where('status', 'published')->orderByDesc('published_at');
        if ($category) $query->where('category', $category);
        return $query->paginate($perPage);
    }

    public function getFeatured(int $limit = 3): \Illuminate\Database\Eloquent\Collection
    {
        return BlogPost::where('status', 'published')->where('is_featured', true)
            ->orderByDesc('published_at')->limit($limit)->get();
    }

    public function getBySlug(string $slug): ?BlogPost
    {
        return BlogPost::where('slug', $slug)->where('status', 'published')->first();
    }

    public function getCategories(): array
    {
        return BlogPost::where('status', 'published')->distinct()->pluck('category')->filter()->values()->toArray();
    }
}
