<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Services\TestimonialService;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function __construct(private TestimonialService $service) {}

    public function index(): JsonResponse
    {
        return response()->json(['data' => TestimonialResource::collection($this->service->getApproved())]);
    }

    public function featured(): JsonResponse
    {
        return response()->json(['data' => TestimonialResource::collection($this->service->getFeatured())]);
    }
}
