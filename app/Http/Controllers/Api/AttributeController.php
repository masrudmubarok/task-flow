<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\StoreAttributeRequest;
use App\Http\Requests\Attribute\UpdateAttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\JsonResponse;

class AttributeController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Attribute::all());
    }

    public function show(Attribute $attribute): JsonResponse
    {
        return response()->json($attribute);
    }

    public function store(StoreAttributeRequest $request): JsonResponse
    {
        try {
            $attribute = Attribute::create($request->validated());
            return response()->json($attribute, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateAttributeRequest $request, Attribute $attribute): JsonResponse
    {
        try {
            $attribute->update($request->validated());
            return response()->json($attribute);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Attribute $attribute): JsonResponse
    {
        try {
            $attribute->delete();
            return response()->json(['message' => 'Attribute deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete attribute',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}