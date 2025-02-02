<?php

namespace App\Models;

use App\Models\BaseModel;

class IncomingBahanBaku extends BaseModel
{
    protected $table = 'incoming_bahan_baku';

    protected $fillable = [
        'id_supplier',
        'invoice_number',
        'invoice_date',
        'is_active'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function details()
    {
        return $this->hasMany(IncomingDetailBahanBaku::class, 'id_incoming_bahan_baku', 'id');
    }

    public function suppliers()
    {
        return $this->belongsTo(Suppliers::class, 'id_supplier', 'id');
    }
}
