<?php

namespace Database\Factories;

use App\Models\Timesheet;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimesheetFactory extends Factory
{
    protected $model = Timesheet::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'project_id' => Project::factory(),
            'task_name' => $this->faker->sentence(3),
            'date' => $this->faker->date(),
            'hours' => $this->faker->randomFloat(1, 1, 12),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}