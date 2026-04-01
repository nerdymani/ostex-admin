<?php

namespace App\Services;

use App\Models\Stat;

class StatsService
{
    public function getActive(): \Illuminate\Database\Eloquent\Collection
    {
        return Stat::where('is_active', true)->orderBy('sort_order')->get();
    }
}
