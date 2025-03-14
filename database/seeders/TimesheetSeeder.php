<?php

namespace Database\Seeders;

use App\Models\Timesheet;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;

class TimesheetSeeder extends Seeder
{
    public function run()
    {
        $user1 = User::first();
        $project1 = Project::first();

        Timesheet::create([
            'user_id' => $user1->id,
            'project_id' => $project1->id,
            'task_name' => 'Development',
            'date' => now()->toDateString(),
            'hours' => 8,
        ]);
        // Tambahkan data timesheet lain sesuai kebutuhan
    }
}