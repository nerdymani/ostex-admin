<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PricingPlanResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'price'         => $this->price,
            'price_label'   => $this->price_label,
            'billing_cycle' => $this->billing_cycle,
            'description'   => $this->description,
            'features'      => $this->features,
            'is_featured'   => $this->is_featured,
            'cta_label'     => $this->cta_label,
            'cta_url'       => $this->cta_url,
        ];
    }
}
