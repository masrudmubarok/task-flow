<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimesheetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => optional($this->user)->id,
            'project_id' => optional($this->project)->id,
            'task_name' => $this->task_name,
            'date' => $this->date?->format('Y-m-d'),
            'hours' => $this->hours,
        ];
    }
}