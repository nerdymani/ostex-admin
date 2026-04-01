<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TeamMemberResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'role'       => $this->role,
            'department' => $this->department,
            'bio'        => $this->bio,
            'photo'      => $this->photo ? asset(Storage::url($this->photo)) : null,
            'linkedin'   => $this->linkedin,
            'twitter'    => $this->twitter,
        ];
    }
}
