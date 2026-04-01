<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BlogPostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'excerpt'     => $this->excerpt,
            'cover_image' => $this->cover_image ? asset(Storage::url($this->cover_image)) : null,
            'author_name' => $this->author_name,
            'category'    => $this->category,
            'tags'        => $this->tags,
            'published_at'=> $this->published_at?->toDateString(),
            'is_featured' => $this->is_featured,
        ];
    }
}
