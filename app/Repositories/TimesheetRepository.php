<?php 

namespace App\Repositories;

use App\Models\Timesheet;

class TimesheetRepository
{
    public function getAll(array $filters = [])
    {
        return Timesheet::filter($filters)->get();
    }

    public function getById($id)
    {
        return Timesheet::findOrFail($id);
    }

    public function create(array $data)
    {
        return Timesheet::create($data);
    }

    public function update($id, array $data)
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->update($data);
        return $timesheet;
    }

    public function delete($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->delete();
    }
}