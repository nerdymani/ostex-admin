<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PortfolioItemResource extends JsonResource
{
    public function toArray($request): array
    {
        $gallery = collect($this->gallery ?? [])->map(fn($img) => asset(Storage::url($img)))->toArray();

        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'description'  => $this->description,
            'client'       => $this->client,
            'category'     => $this->category,
            'image'        => $this->image ? asset(Storage::url($this->image)) : null,
            'gallery'      => $gallery,
            'technologies' => $this->technologies,
            'project_url'  => $this->project_url,
            'completed_at' => $this->completed_at?->toDateString(),
            'is_featured'  => $this->is_featured,
        ];
    }
}
