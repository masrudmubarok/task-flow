<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Http\Resources\AttributeResource;
use App\Services\AttributeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Attribute",
 *     description="API Endpoints for Managing Attribute"
 * )
 */
class AttributeController extends Controller
{
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    /**
     * @OA\Get(
     *     path="/api/attribute",
     *     tags={"Attribute"},
     *     summary="Get all attributes with filtering",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="filters[name]",
     *         in="query",
     *         description="Filter by attribute name",
     *         required=false,
     *         @OA\Schema(type="string", example="Department")
     *     ),
     *     @OA\Parameter(
     *         name="filters[type]",
     *         in="query",
     *         description="Filter by attribute type (e.g., text, number)",
     *         required=false,
     *         @OA\Schema(type="string", example="text")
     *     ),
     *     @OA\Response(response=200, description="Filtered list of attributes"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->query('filters', []);
        $attributes = $this->attributeService->getAll($filters);
        return response()->json(AttributeResource::collection($attributes));
    }

    /**
     * @OA\Get(
     *     path="/api/attribute/{id}",
     *     summary="Get attribute by ID",
     *     tags={"Attribute"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Attribute detail"),
     *     @OA\Response(response=404, description="Attribute not found")
     * )
     */
    public function getAttributeById($id): JsonResponse
    {
        $attribute = $this->attributeService->getAttributeById($id);
        return response()->json($attribute);
    }

    /**
     * @OA\Post(
     *     path="/api/attribute",
     *     summary="Add a new attribute",
     *     tags={"Attribute"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "type"},
     *             @OA\Property(property="name", type="string", example="Priority"),
     *             @OA\Property(property="type", type="string", example="text")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Timesheet added successfully"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function addAttribute(AttributeRequest $request): JsonResponse
    {
        $attribute = $this->attributeService->createAttribute($request->validated());
        return response()->json($attribute, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/attribute/{id}",
     *     summary="Update an attribute",
     *     tags={"Attribute"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "type"},
     *             @OA\Property(property="name", type="string", example="Priority"),
     *             @OA\Property(property="type", type="string", example="text")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Attribute updated successfully"),
     *     @OA\Response(response=404, description="Attribute not found")
     * )
     */
    public function updateAttribute(AttributeRequest $request, $id): JsonResponse
    {
        $attribute = $this->attributeService->updateAttribute($id, $request->validated());
        return response()->json($attribute);
    }

    /**
     * @OA\Delete(
     *     path="/api/attribute/{id}",
     *     summary="Delete an attribute",
     *     tags={"Attribute"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Attribute deleted successfully"),
     *     @OA\Response(response=404, description="Attribute not found")
     * )
     */
    public function deleteAttribute($id): JsonResponse
    {
        $this->attributeService->deleteAttribute($id);
        return response()->json(['message' => 'Attribute deleted successfully'], 200);
    }
}