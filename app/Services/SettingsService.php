<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService
{
    public function getPublic(): \Illuminate\Database\Eloquent\Collection
    {
        return Setting::where('key', '!=', 'maintenance_mode')->get();
    }

    public function getGroup(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return Setting::where('group', $group)->get();
    }
}
