<?php

namespace App\Models;

use App\Models\BaseModel;

class BatchDetail extends BaseModel
{
    protected $table = 'batch_details';

    protected $fillable = [
        'id_batch',
        'id_reference',
        'product_code',
        'reference_type',
        'quantity',
        'total_yard',
        'cost_per_yard',
        'sub_total',
        'remarks',
        'is_active',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'id_batch');
    }
}
