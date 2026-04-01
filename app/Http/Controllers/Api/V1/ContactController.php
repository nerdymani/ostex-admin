<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(private ContactService $service) {}

    public function store(Request $request): JsonResponse
    {
        try {
            $inquiry = $this->service->store($request->all());
            return response()->json(['success' => true, 'data' => ['id' => $inquiry->id]], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to process request'], 500);
        }
    }
}
