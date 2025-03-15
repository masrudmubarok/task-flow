<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('attributeValues')->get();
        return response()->json($projects);
    }

    public function show(Project $project)
    {
        $project->load('attributeValues');
        return response()->json($project);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project = Project::create($request->all());

        if ($request->has('attributes')) {
            foreach ($request->attributes as $attributeData) {
                $attributeValue = new AttributeValue();
                $attributeValue->attribute_id = $attributeData['attribute_id'];
                $attributeValue->value = $attributeData['value'];
                $project->attributeValues()->save($attributeValue);
            }
        }

        return response()->json($project, 201);
    }

    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project->update($request->all());

        if ($request->has('attributes')) {
            $project->attributeValues()->delete();
            foreach ($request->attributes as $attributeData) {
                $attributeValue = new AttributeValue();
                $attributeValue->attribute_id = $attributeData['attribute_id'];
                $attributeValue->value = $attributeData['value'];
                $project->attributeValues()->save($attributeValue);
            }
        }

        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(null, 204);
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
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->has('department')) {
            $query->whereHas('attributeValues', function ($q) use ($request) {
                $q->where('value', $request->department)
                    ->whereHas('attribute', function ($q) {
                        $q->where('name', 'Department');
                    });
            });
        }

        if ($request->has('sort_by') && $request->has('sort_order')) {
            $query->orderBy($request->sort_by, $request->sort_order);
        }

        $projects = $query->paginate(10);

        return response()->json($projects);
    }
}