<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioItemResource;
use App\Services\PortfolioService;
use Illuminate\Http\JsonResponse;

class PortfolioController extends Controller
{
    public function __construct(private PortfolioService $service) {}

    public function index(): JsonResponse
    {
        $category = request()->get('category');
        $featured = request()->boolean('featured');
        $limit = (int) request()->get('limit', 100);

        if ($featured) {
            $items = $this->service->getFeatured($limit);
            return response()->json(['data' => PortfolioItemResource::collection($items)]);
        }

        $paginated = $this->service->getPaginated($category);
        return response()->json([
            'data' => PortfolioItemResource::collection($paginated->items()),
            'meta' => ['total' => $paginated->total(), 'last_page' => $paginated->lastPage(), 'current_page' => $paginated->currentPage()],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $item = $this->service->getBySlug($slug);
        if (!$item) return response()->json(['data' => null], 404);
        return response()->json(['data' => new PortfolioItemResource($item)]);
    }

    public function categories(): JsonResponse
    {
        return response()->json(['data' => $this->service->getCategories()]);
    }
}
