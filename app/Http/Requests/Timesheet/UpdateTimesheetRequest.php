<?php

namespace App\Http\Requests\Timesheet;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimesheetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'exists:users,id',
            'project_id' => 'exists:projects,id',
            'task_name' => 'string|max:255',
            'date' => 'date',
            'hours' => 'integer|min:1|max:24',
        ];
    }
}