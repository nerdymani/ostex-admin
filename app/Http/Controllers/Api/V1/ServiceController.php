<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    public function __construct(private ServiceService $service) {}

    public function index(): JsonResponse
    {
        $featured = request()->boolean('featured');
        $limit = (int) request()->get('limit', 100);

        $services = $featured
            ? $this->service->getFeatured($limit)
            : $this->service->getAll();

        return response()->json(['data' => ServiceResource::collection($services)]);
    }

    public function show(string $slug): JsonResponse
    {
        $service = $this->service->getBySlug($slug);
        if (!$service) return response()->json(['data' => null], 404);
        return response()->json(['data' => new ServiceResource($service)]);
    }

    public function categories(): JsonResponse
    {
        return response()->json(['data' => $this->service->getCategories()]);
    }
}
