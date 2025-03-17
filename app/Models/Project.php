<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\ProjectStatus;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    protected $casts = [
        'status' => ProjectStatus::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if (in_array($key, ['name', 'status'])) {
                $query->where($key, 'LIKE', "%$value%");
            } else {
                $query->whereHas('attributeValues', function ($q) use ($key, $value) {
                    $q->where('attribute_id', function ($subQuery) use ($key) {
                        $subQuery->select('id')->from('attributes')->where('name', $key);
                    })->where('value', 'LIKE', "%$value%");
                });
            }
        }

        return $query;
    }
}