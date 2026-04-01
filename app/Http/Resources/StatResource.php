<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'label'       => $this->label,
            'value'       => $this->value,
            'icon'        => $this->icon,
            'description' => $this->description,
        ];
    }
}
