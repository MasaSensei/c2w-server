<?php

namespace App\Models;

use App\Models\BaseModel;

class InventoryBahanBakuToCutters extends BaseModel
{
    protected $table = 'inventory_bahan_baku_to_cutters';

    protected $fillable = [
        'id_bahan_baku',
        'id_size',
        'id_model',
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

    public function size()
    {
        return $this->belongsTo(Size::class, 'id_size');
    }

    public function model()
    {
        return $this->belongsTo(Model::class, 'id_model');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'material_to_cutters_item_category', 'id_inv_cutters_material', 'id_item_category');
    }
}
