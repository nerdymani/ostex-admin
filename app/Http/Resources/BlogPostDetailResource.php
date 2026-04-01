<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BlogPostDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        return array_merge((new BlogPostResource($this->resource))->toArray($request), [
            'body' => $this->body,
        ]);
    }
}
