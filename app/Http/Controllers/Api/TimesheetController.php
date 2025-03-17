<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimesheetRequest;
use App\Http\Resources\TimesheetResource;
use App\Services\TimesheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Timesheet", description="Endpoints for managing timesheets")
 */
class TimesheetController extends Controller
{
    protected $timesheetService;

    public function __construct(TimesheetService $timesheetService)
    {
        $this->timesheetService = $timesheetService;
    }

    /**
     * @OA\Get(
     *     path="/api/timesheet",
     *     tags={"Timesheet"},
     *     summary="Get all timesheets with filtering",
     *     security={{"bearerAuth":{}}},

     *     @OA\Parameter(
     *         name="filters[user_id]",
     *         in="query",
     *         description="Filter by user ID",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="filters[project_id]",
     *         in="query",
     *         description="Filter by project ID",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="filters[hour][gt]",
     *         in="query",
     *         description="Filter timesheets where hours logged are greater than a certain value",
     *         required=false,
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Parameter(
     *         name="filters[hour][lt]",
     *         in="query",
     *         description="Filter timesheets where hours logged are less than a certain value",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="filters[date][gt]",
     *         in="query",
     *         description="Filter timesheets with date greater than",
     *         required=false,
     *         @OA\Schema(type="string", format="date", example="2024-01-01")
     *     ),

     *     @OA\Response(response=200, description="Filtered list of timesheets"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->query('filters', []);
        $timesheets = $this->timesheetService->getAll($filters);
        return response()->json(TimesheetResource::collection($timesheets));
    }


    /**
     * @OA\Get(
     *     path="/api/timesheet/{id}",
     *     tags={"Timesheet"},
     *     summary="Get timesheet by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Timesheet detail"),
     *     @OA\Response(response=404, description="Timesheet not found")
     * )
     */
    public function getTimesheetById($id)
    {
        $timesheet = $this->timesheetService->getTimesheetById($id);
        return response()->json($timesheet);
    }

    /**
     * @OA\Post(
     *     path="/api/timesheet",
     *     tags={"Timesheet"},
     *     summary="Create a new timesheet",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="project_id", type="integer", example=2),
     *             @OA\Property(property="task_name", type="string", example="Worked on project backend"),
     *             @OA\Property(property="date", type="string", format="date", example="2024-03-16"),
     *             @OA\Property(property="hours", type="integer", example=8)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Timesheet added successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function addTimesheet(Request $request)
    {
        $timesheet = $this->timesheetService->createTimesheet($request->all());
        return response()->json($timesheet, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/timesheet/{id}",
     *     tags={"Timesheet"},
     *     summary="Update timesheet details",
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
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="project_id", type="integer", example=2),
     *             @OA\Property(property="task_name", type="string", example="Worked on project frontend"),
     *             @OA\Property(property="date", type="string", format="date", example="2024-03-16"),
     *             @OA\Property(property="hours", type="integer", example=8)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Timesheet updated successfully"),
     *     @OA\Response(response=404, description="Timesheet not found")
     * )
     */
    public function updateTimesheet(Request $request, $id)
    {
        $timesheet = $this->timesheetService->updateTimesheet($id, $request->all());
        return response()->json($timesheet);
    }

    /**
     * @OA\Delete(
     *     path="/api/timesheet/{id}",
     *     tags={"Timesheet"},
     *     summary="Delete a timesheet",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Timesheet deleted successfully"),
     *     @OA\Response(response=404, description="Timesheet not found")
     * )
     */
    public function deleteTimesheet($id)
    {
        $this->timesheetService->deleteTimesheet($id);
        return response()->json(['message' => 'Timesheet deleted successfully'], 200);
    }
}