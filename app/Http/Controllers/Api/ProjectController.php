<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Project", description="Endpoints for managing projects")
 */
class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * @OA\Get(
     *     path="/api/project",
     *     tags={"Project"},
     *     summary="Get all projects with filtering",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="filters[name]",
     *         in="query",
     *         description="Filter by project name",
     *         required=false,
     *         @OA\Schema(type="string", example="Project A")
     *     ),
     *     @OA\Parameter(
     *         name="filters[department]",
     *         in="query",
     *         description="Filter by department (EAV attribute)",
     *         required=false,
     *         @OA\Schema(type="string", example="IT")
     *     ),
     *     @OA\Parameter(
     *         name="filters[priority]",
     *         in="query",
     *         description="Filter by priority (EAV attribute)",
     *         required=false,
     *         @OA\Schema(type="string", example="Medium")
     *     ),
     *     @OA\Parameter(
     *         name="filters[status]",
     *         in="query",
     *         description="Filter by status (e.g., ongoing, completed)",
     *         required=false,
     *         @OA\Schema(type="string", example="ongoing")
     *     ),
     *     @OA\Parameter(
     *         name="filters[created_at][gt]",
     *         in="query",
     *         description="Filter projects created after a specific date",
     *         required=false,
     *         @OA\Schema(type="string", format="date", example="2024-01-01")
     *     ),
     *     @OA\Parameter(
     *         name="filters[name][like]",
     *         in="query",
     *         description="Filter by name using LIKE operator",
     *         required=false,
     *         @OA\Schema(type="string", example="%Project%")
     *     ),
     *     @OA\Response(response=200, description="Filtered list of projects"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->query('filters', []);
        $projects = $this->projectService->getAll($filters);
        return response()->json(ProjectResource::collection($projects));
    }

    /**
     * @OA\Get(
     *     path="/api/project/{id}",
     *     tags={"Project"},
     *     summary="Get project by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Project details"),
     *     @OA\Response(response=404, description="Project not found")
     * )
     */
    public function getProjectById($id): JsonResponse
    {
        $project = $this->projectService->getProjectById($id);
        return response()->json(new ProjectResource($project));
    }

    /**
     * @OA\Post(
     *     path="/api/project",
     *     tags={"Project"},
     *     summary="Create a new project",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Project Finance Report"),
     *             @OA\Property(property="status", type="string", example="ongoing"),
     *             @OA\Property(
     *                 property="attributes",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="attribute_id", type="integer", example=1),
     *                     @OA\Property(property="value", type="string", example="Finance")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Project created successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function addProject(ProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->createProject($request->validated());
        return response()->json(new ProjectResource($project), 201);
    }

    /**
     * @OA\Put(
     *     path="/api/project/{id}",
     *     tags={"Project"},
     *     summary="Update project details",
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
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Project Finance Report"),
     *             @OA\Property(property="status", type="string", example="ongoing"),
     *             @OA\Property(
     *                 property="attributes",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="attribute_id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Department"),
     *                     @OA\Property(property="value", type="string", example="Finance")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Project updated successfully"),
     *     @OA\Response(response=404, description="Project not found")
     * )
     */
    public function updateProject(ProjectRequest $request, $id): JsonResponse
    {
        $project = $this->projectService->updateProject($id, $request->validated());
        return response()->json(new ProjectResource($project));
    }

    /**
     * @OA\Delete(
     *     path="/api/project/{id}",
     *     tags={"Project"},
     *     summary="Delete a project",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Project deleted successfully"),
     *     @OA\Response(response=404, description="Project not found")
     * )
     */
    public function deleteProject($id): JsonResponse
    {
        $this->projectService->deleteProject($id);
        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}