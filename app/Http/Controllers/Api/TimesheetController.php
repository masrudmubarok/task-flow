<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{
    public function index()
    {
        return response()->json(Timesheet::all());
    }

    public function show(Timesheet $timesheet)
    {
        return response()->json($timesheet);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $timesheet = Timesheet::create($request->all());
        return response()->json($timesheet, 201);
    }

    public function update(Request $request, Timesheet $timesheet)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'exists:users,id',
            'project_id' => 'exists:projects,id',
            'task_name' => 'string|max:255',
            'date' => 'date',
            'hours' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $timesheet->update($request->all());
        return response()->json($timesheet);
    }

    public function destroy(Timesheet $timesheet)
    {
        $timesheet->delete();
        return response()->json(null, 204);
    }
}