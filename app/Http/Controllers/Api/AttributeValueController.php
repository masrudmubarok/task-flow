<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use App\Models\AttributeValue;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AttributeValueController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(AttributeValue::paginate(10)); // ✅ Gunakan pagination
    }

    public function show(AttributeValue $attributeValue): JsonResponse
    {
        return response()->json($attributeValue);
    }

    public function store(StoreAttributeValueRequest $request): JsonResponse
    {
        try {
            $attributeValue = AttributeValue::create($request->validated());
            return response()->json($attributeValue, 201);
        } catch (\Exception $e) {
            Log::error('Error storing attribute value: ' . $e->getMessage());
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateAttributeValueRequest $request, AttributeValue $attributeValue): JsonResponse
    {
        try {
            $attributeValue->update($request->validated());
            return response()->json($attributeValue);
        } catch (\Exception $e) {
            Log::error('Error updating attribute value: ' . $e->getMessage());
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(AttributeValue $attributeValue): JsonResponse
    {
        try {
            $attributeValue->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error('Error deleting attribute value: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to delete attribute value',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}