<?php

namespace App\Models;

class Size extends BaseModel
{
    protected $table = 'size';

    protected $fillable = [
        'size',
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
