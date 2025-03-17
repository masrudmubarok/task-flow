<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ProjectStatus;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'status' => $this->faker->randomElement(ProjectStatus::cases())->value,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}