<?php

namespace App\Models;

class OrderBahanBakuDetails extends BaseModel
{
    protected $table = 'order_bahan_baku_details';

    protected $fillable = [
        'id_order_bahan_baku',
        'id_inv_cutters_material',
        'product_code',
        'roll',
        'total_yard',
        'cost_per_yard',
        'sub_total',
        'remarks',
    ];

    public function orderBahanBaku()
    {
        return $this->belongsTo(OrderBahanBaku::class, 'id_order_bahan_baku');
    }

    public function inventoryBahanBakuToCutters()
    {
        return $this->belongsTo(InventoryBahanBakuToCutters::class, 'id_inv_cutters_material');
    }
}
