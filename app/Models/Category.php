<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $table = 'item_categories';

    protected $fillable = [
        'category',
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
