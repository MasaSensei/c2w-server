<?php

namespace App\Models;

use App\Models\BaseModel;

class InventoryBahanBakuToCutters extends BaseModel
{
    protected $table = 'inventory_bahan_baku_to_cutters';

    protected $fillable = [
        'id_bahan_baku',
        'transfer_date',
        'item',
        'total_roll',
        'total_yard',
        'status',
        'remarks',
        'is_active',
    ];

    protected $dates = [
        'transfer_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function bahan_baku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku');
    }
}
