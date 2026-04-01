<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Services\FaqService;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    public function __construct(private FaqService $service) {}

    public function index(): JsonResponse
    {
        $grouped = $this->service->getAllGrouped();
        $result = [];
        foreach ($grouped as $category => $faqs) {
            $result[$category] = FaqResource::collection(collect($faqs))->toArray(request());
        }
        return response()->json(['data' => $result]);
    }

    public function byCategory(string $category): JsonResponse
    {
        return response()->json(['data' => FaqResource::collection($this->service->getByCategory($category))]);
    }
}
