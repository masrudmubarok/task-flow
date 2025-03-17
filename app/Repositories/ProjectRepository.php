<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function getAll(array $filters)
    {
        return Project::filter($filters)->get();
    }

    public function getById($id)
    {
        return Project::findOrFail($id);
    }

    public function create(array $data)
    {
        return Project::create($data);
    }

    public function update($id, array $data)
    {
        $project = Project::findOrFail($id);
        $project->update($data);
        return $project;
    }

    public function delete($id)
    {
        Project::destroy($id);
    }
}