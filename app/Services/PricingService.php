<?php

namespace App\Services;

use App\Models\PricingPlan;

class PricingService
{
    public function getActive(): \Illuminate\Database\Eloquent\Collection
    {
        return PricingPlan::where('is_active', true)->orderBy('sort_order')->get();
    }
}
