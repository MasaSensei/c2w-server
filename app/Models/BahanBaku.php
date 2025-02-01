<?php

namespace App\Models;




class BahanBaku extends BaseModel
{
    protected $table = 'bahan_baku';

    protected $fillable = [
        'id_code',
        'id_color',
        'total_roll',
        'item',
        'total_yard',
        'cost_per_yard',
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

    public function code()
    {
        return $this->belongsTo(Code::class, 'id_code', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'id_color', 'id');
    }
}
