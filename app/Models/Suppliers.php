<?php

namespace App\Models;

class Suppliers extends BaseModel
{
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'contact',
        'address',
        'remarks',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
