<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeValueController extends Controller
{
    public function index()
    {
        return response()->json(AttributeValue::all());
    }

    public function show(AttributeValue $attributeValue)
    {
        return response()->json($attributeValue);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attribute_id' => 'required|exists:attributes,id',
            'entity_id' => 'required|integer',
            'entity_type' => 'required|string',
            'value' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $attributeValue = AttributeValue::create($request->all());
        return response()->json($attributeValue, 201);
    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $validator = Validator::make($request->all(), [
            'attribute_id' => 'exists:attributes,id',
            'entity_id' => 'integer',
            'entity_type' => 'string',
            'value' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $attributeValue->update($request->all());
        return response()->json($attributeValue);
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();
        return response()->json(null, 204);
    }
}