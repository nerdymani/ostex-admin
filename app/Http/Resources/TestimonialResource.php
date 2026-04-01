<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TestimonialResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'role'    => $this->role,
            'company' => $this->company,
            'message' => $this->message,
            'photo'   => $this->photo ? asset(Storage::url($this->photo)) : null,
            'rating'  => $this->rating,
        ];
    }
}
