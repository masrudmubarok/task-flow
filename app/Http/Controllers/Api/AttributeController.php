<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Services\AttributeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->query();
        $attributes = $this->attributeService->getAllAttributes($filters);
        return response()->json($attributes);
    }

    public function getAttributeById($id): JsonResponse
    {
        $attribute = $this->attributeService->getAttributeById($id);
        return response()->json($attribute);
    }

    public function addAttribute(AttributeRequest $request): JsonResponse
    {
        $attribute = $this->attributeService->createAttribute($request->validated());
        return response()->json($attribute, 201);
    }

    public function updateAttribute(AttributeRequest $request, $id): JsonResponse
    {
        $attribute = $this->attributeService->updateAttribute($id, $request->validated());
        return response()->json($attribute);
    }

    public function deleteAttribute($id): JsonResponse
    {
        $this->attributeService->deleteAttribute($id);
        return response()->json(['message' => 'Attribute deleted successfully'], 200);
    }
}