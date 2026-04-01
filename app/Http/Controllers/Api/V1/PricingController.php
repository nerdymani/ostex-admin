<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PricingPlanResource;
use App\Services\PricingService;
use Illuminate\Http\JsonResponse;

class PricingController extends Controller
{
    public function __construct(private PricingService $service) {}

    public function index(): JsonResponse
    {
        return response()->json(['data' => PricingPlanResource::collection($this->service->getActive())]);
    }
}
