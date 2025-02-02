<?php

namespace App\Models;

use App\Models\BaseModel;

class IncomingDetailBahanBaku extends BaseModel
{
    protected $table = 'incoming_detail_bahan_baku';

    protected $fillable = [
        'id_incoming_bahan_baku',
        'id_bahan_baku',
        'length_yard',
        'roll',
        'total_yard',
        'cost_per_yard',
        'sub_total',
        'remarks',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function incomingBahanBaku()
    {
        return $this->belongsTo(IncomingBahanBaku::class, 'id_incoming_bahan_baku');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku');
    }
}
