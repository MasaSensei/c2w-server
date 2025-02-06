<?php

namespace App\Models;

class OrderBahanBaku extends BaseModel
{
    protected $table = 'order_bahan_baku';

    protected $fillable = [
        'invoice_number',
        'order_date',
        'due_date',
        'remarks',
        'status',
        'is_active',
    ];

    public function details()
    {
        return $this->hasMany(OrderBahanBakuDetails::class, 'id_order_bahan_baku', 'id');
    }
}
