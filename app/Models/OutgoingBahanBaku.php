<?php

namespace App\Models;


use App\Models\BaseModel;


class OutgoingBahanBaku extends BaseModel
{
    protected $table = 'outgoing_bahan_baku';

    protected $fillable = [
        'id_bahan_baku',
        'outgoing_date',
        'total_roll',
        'total_yard',
        'status',
        'incoming_invoice_number',
        'remarks',
        'is_active'
    ];

    protected $dates = ['outcoming_date', 'created_at', 'updated_at', 'deleted_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function bahanbaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku', 'id');
    }
}
