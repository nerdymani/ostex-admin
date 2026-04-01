<?php

namespace App\Services;

use App\Models\TeamMember;

class TeamService
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return TeamMember::where('is_active', true)->where('show_on_site', true)->orderBy('sort_order')->get();
    }

    public function getBySlug(string $slug): ?TeamMember
    {
        return TeamMember::where('slug', $slug)->where('is_active', true)->first();
    }
}
