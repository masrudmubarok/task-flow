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
        collect($filters)->each(function ($value, $key) use ($query) {
            if (in_array($key, ['user_id', 'project_id'])) {
                $query->where($key, $value);
            } elseif ($key === 'task_name') {
                $query->where($key, 'LIKE', "%$value%");
            } elseif (is_array($value) && in_array($key, ['hours', 'date'])) {
                foreach ($value as $operator => $val) {
                    $query->where($key, match ($operator) {
                        'gt' => '>',
                        'lt' => '<',
                        'eq' => '=',
                        default => '=',
                    }, $val);
                }
            }
        });

        return $query;
    }

}