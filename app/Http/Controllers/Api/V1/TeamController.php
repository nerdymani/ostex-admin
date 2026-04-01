<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamMemberResource;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    public function __construct(private TeamService $service) {}

    public function index(): JsonResponse
    {
        return response()->json(['data' => TeamMemberResource::collection($this->service->getAll())]);
    }

    public function show(string $slug): JsonResponse
    {
        $member = $this->service->getBySlug($slug);
        if (!$member) return response()->json(['data' => null], 404);
        return response()->json(['data' => new TeamMemberResource($member)]);
    }
}
