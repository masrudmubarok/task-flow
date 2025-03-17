<?php

namespace App\Services;

use App\Repositories\TimesheetRepository;

class TimesheetService
{
    protected $timesheetRepository;

    public function __construct(TimesheetRepository $timesheetRepository)
    {
        $this->timesheetRepository = $timesheetRepository;
    }

    public function getAll(array $filters = [])
    {
        return $this->timesheetRepository->getAll($filters);
    }

    public function getTimesheetById($id)
    {
        return $this->timesheetRepository->getById($id);
    }

    public function createTimesheet(array $data)
    {
        return $this->timesheetRepository->create($data);
    }

    public function updateTimesheet($id, array $data)
    {
        return $this->timesheetRepository->update($id, $data);
    }

    public function deleteTimesheet($id)
    {
        return $this->timesheetRepository->delete($id);
    }
}