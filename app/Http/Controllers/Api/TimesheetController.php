<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimesheetRequest;
use App\Http\Resources\TimesheetResource;
use App\Services\TimesheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    protected $timesheetService;

    public function __construct(TimesheetService $timesheetService)
    {
        $this->timesheetService = $timesheetService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->query();
        $timesheets = $this->timesheetService->getAll($filters);
        return response()->json(TimesheetResource::collection($timesheets));
    }

    public function getTimesheetById($id): JsonResponse
    {
        $timesheet = $this->timesheetService->getTimesheetById($id);
        return response()->json(new TimesheetResource($timesheet));
    }

    public function addTimesheet(TimesheetRequest $request): JsonResponse
    {
        $timesheet = $this->timesheetService->createTimesheet($request->validated());
        return response()->json(new TimesheetResource($timesheet), 201);
    }

    public function updateTimesheet(TimesheetRequest $request, $id): JsonResponse
    {
        $timesheet = $this->timesheetService->updateTimesheet($id, $request->validated());
        return response()->json(new TimesheetResource($timesheet));
    }

    public function deleteTimesheet($id): JsonResponse
    {
        $this->timesheetService->deleteTimesheet($id);
        return response()->json(['message' => 'Timesheet deleted successfully'], 200);
    }
}