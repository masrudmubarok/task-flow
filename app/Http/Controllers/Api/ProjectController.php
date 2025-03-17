<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->query();
        $projects = $this->projectService->getAll($filters);
        return response()->json(ProjectResource::collection($projects));
    }

    public function getProjectById($id): JsonResponse
    {
        $project = $this->projectService->getProjectById($id);
        return response()->json(new ProjectResource($project));
    }

    public function addProject(ProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->createProject($request->validated());
        return response()->json(new ProjectResource($project), 201);
    }

    public function updateProject(ProjectRequest $request, $id): JsonResponse
    {
        $project = $this->projectService->updateProject($id, $request->validated());
        return response()->json(new ProjectResource($project));
    }

    public function deleteProject($id): JsonResponse
    {
        $this->projectService->deleteProject($id);
        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}