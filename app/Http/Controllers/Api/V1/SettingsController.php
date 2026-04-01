<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Services\SettingsService;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    public function __construct(private SettingsService $service) {}

    public function index(): JsonResponse
    {
        $settings = $this->service->getPublic();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->value;
        }
        return response()->json(['data' => $result]);
    }
}
