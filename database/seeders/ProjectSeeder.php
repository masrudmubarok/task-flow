<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::create([
            'name' => 'Project A',
            'status' => 'Active',
        ]);

        Project::create([
            'name' => 'Project B',
            'status' => 'Pending',
        ]);
    }
}