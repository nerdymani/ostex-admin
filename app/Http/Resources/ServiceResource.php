<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'short_desc'  => $this->short_desc,
            'description' => $this->description,
            'icon'        => $this->icon,
            'image'       => $this->image ? asset(Storage::url($this->image)) : null,
            'category'    => $this->category,
            'is_featured' => $this->is_featured,
            'sort_order'  => $this->sort_order,
        ];
    }
}
