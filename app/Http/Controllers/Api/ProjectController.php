<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('attributeValues')->paginate(10);
        return response()->json($projects);
    }

    public function show(Project $project)
    {
        $project->load('attributeValues');
        return response()->json($project);
    }

    public function store(StoreProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $project = Project::create($request->only('name', 'status'));

            if ($request->has('attributes')) {
                foreach ($request->attributes as $attributeData) {
                    AttributeValue::create([
                        'project_id' => $project->id,
                        'attribute_id' => $attributeData['attribute_id'],
                        'value' => $attributeData['value'],
                    ]);
                }
            }

            DB::commit();
            return response()->json($project, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Project Store Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        DB::beginTransaction();
        try {
            $project->update($request->only('name', 'status'));

            if ($request->has('attributes')) {
                $project->attributeValues()->delete(); // Hapus atribut lama

                foreach ($request->attributes as $attributeData) {
                    AttributeValue::create([
                        'project_id' => $project->id,
                        'attribute_id' => $attributeData['attribute_id'],
                        'value' => $attributeData['value'],
                    ]);
                }
            }

            DB::commit();
            return response()->json($project);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Project Update Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function destroy(Project $project)
    {
        DB::beginTransaction();
        try {
            $project->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Project Delete Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function filter(Request $request)
    {
        $query = Project::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));

            if ($startDate <= $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        if ($request->has('department')) {
            $query->whereHas('attributeValues', function ($q) use ($request) {
                $q->where('value', $request->department)
                    ->whereHas('attribute', function ($q) {
                        $q->where('name', 'Department');
                    });
            });
        }

        if ($request->has('sort_by')) {
            $sortOrder = $request->get('sort_order', 'asc');
            if (!in_array($sortOrder, ['asc', 'desc'])) {
                $sortOrder = 'asc';
            }
            $query->orderBy($request->sort_by, $sortOrder);
        }

        $projects = $query->paginate(10);

        return response()->json($projects);
    }
}