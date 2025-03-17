<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getAll(array $filters)
    {
        return $this->projectRepository->getAll($filters);
    }

    public function getProjectById($id)
    {
        return $this->projectRepository->getById($id);
    }

    public function createProject(array $data)
    {
        $project = $this->projectRepository->create($data);
        $this->syncAttributes($project, $data['attributes'] ?? []);
        return $project;
    }

    public function updateProject($id, array $data)
    {
        $project = $this->projectRepository->update($id, $data);
        $this->syncAttributes($project, $data['attributes'] ?? []);
        return $project;
    }

    public function deleteProject($id)
    {
        $this->projectRepository->delete($id);
    }

    private function syncAttributes(Project $project, array $attributes)
    {
        $project->attributeValues()->delete();
        if (!empty($attributes)) {
            $project->attributeValues()->createMany($attributes);
        }
    }
}