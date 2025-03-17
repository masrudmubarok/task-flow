<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'project_id', 'task_name', 'date', 'hours'];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if ($key === 'task_name') {
                $query->where($key, 'LIKE', "%$value%");
            } else {
                $query->where($key, $value);
            }
        }

        return $query;
    }

}