<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeValueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attribute_id' => 'sometimes|exists:attributes,id',
            'entity_id' => 'sometimes|integer',
            'entity_type' => 'sometimes|string',
            'value' => 'sometimes|string',
        ];
    }
}