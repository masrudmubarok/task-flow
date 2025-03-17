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
            if (is_array($value)) {
                if (isset($value['like'])) {
                    $query->where($key, 'LIKE', $value['like']);
                } elseif (isset($value['gt'])) {
                    $query->where($key, '>', $value['gt']);
                }
            } elseif (in_array($key, ['name', 'status'])) {
                $query->where($key, $value);
            } else {
                $query->whereHas('attributeValues', function ($q) use ($key, $value) {
                    $q->whereHas('attribute', fn($subQuery) => $subQuery->where('name', $key))
                    ->where('value', 'LIKE', "%$value%");
                });
            }
        }
    }
}