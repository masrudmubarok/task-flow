<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timesheet\StoreTimesheetRequest;
use App\Http\Requests\Timesheet\UpdateTimesheetRequest;
use App\Models\Timesheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimesheetController extends Controller
{
    public function index()
    {
        $timesheets = Timesheet::paginate(10); // Menggunakan pagination agar lebih efisien
        return response()->json($timesheets);
    }

    public function show(Timesheet $timesheet)
    {
        return response()->json($timesheet);
    }

    public function store(StoreTimesheetRequest $request)
    {
        DB::beginTransaction();
        try {
            $timesheet = Timesheet::create($request->validated());

            DB::commit();
            return response()->json($timesheet, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Timesheet Store Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateTimesheetRequest $request, Timesheet $timesheet)
    {
        DB::beginTransaction();
        try {
            $timesheet->update($request->validated());

            DB::commit();
            return response()->json($timesheet);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Timesheet Update Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Timesheet $timesheet)
    {
        DB::beginTransaction();
        try {
            $timesheet->delete();

            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Timesheet Delete Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}