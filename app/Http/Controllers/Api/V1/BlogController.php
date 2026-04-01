<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogPostResource;
use App\Http\Resources\BlogPostDetailResource;
use App\Services\BlogService;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    public function __construct(private BlogService $service) {}

    public function index(): JsonResponse
    {
        $perPage = (int) request()->get('per_page', 9);
        $category = request()->get('category');
        $paginated = $this->service->getPaginated($perPage, $category);
        return response()->json([
            'data' => BlogPostResource::collection($paginated->items()),
            'meta' => ['total' => $paginated->total(), 'last_page' => $paginated->lastPage(), 'current_page' => $paginated->currentPage()],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $post = $this->service->getBySlug($slug);
        if (!$post) return response()->json(['data' => null], 404);
        return response()->json(['data' => new BlogPostDetailResource($post)]);
    }

    public function categories(): JsonResponse
    {
        return response()->json(['data' => $this->service->getCategories()]);
    }
}
