<?php

namespace App\Models;

class Model extends BaseModel
{
    protected $table = 'model';

    protected $fillable = [
        'model',
        'remarks',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
