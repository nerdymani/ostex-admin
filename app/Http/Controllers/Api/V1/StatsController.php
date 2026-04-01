<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatResource;
use App\Services\StatsService;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    public function __construct(private StatsService $service) {}

    public function index(): JsonResponse
    {
        return response()->json(['data' => StatResource::collection($this->service->getActive())]);
    }
}
