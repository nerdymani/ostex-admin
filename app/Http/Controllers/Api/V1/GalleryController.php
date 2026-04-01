<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryItemResource;
use App\Services\GalleryService;
use Illuminate\Http\JsonResponse;

class GalleryController extends Controller
{
    public function __construct(private GalleryService $service) {}

    public function index(): JsonResponse
    {
        $category = request()->get('category');
        return response()->json(['data' => GalleryItemResource::collection($this->service->getActive($category))]);
    }

    public function categories(): JsonResponse
    {
        return response()->json(['data' => $this->service->getCategories()]);
    }
}
