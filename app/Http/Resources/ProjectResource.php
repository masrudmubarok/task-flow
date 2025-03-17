<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status->value,
            'attributes' => $this->attributeValues->map(function ($attributeValue) {
                return [
                    'attribute_id' => $attributeValue->attribute_id,
                    'value' => $attributeValue->value,
                ];
            }),
        ];
    }
}