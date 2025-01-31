<?php

namespace App\Models;

class Color extends BaseModel
{
    protected $table = 'color';

    protected $fillable = [
        'color',
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

    public function bahanbaku()
    {
        return $this->hasMany(BahanBaku::class, 'id_color', 'id');
    }
}
