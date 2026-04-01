<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GalleryItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'image'    => asset(Storage::url($this->image)),
            'category' => $this->category,
            'alt_text' => $this->alt_text,
        ];
    }
}
