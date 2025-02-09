<?php

namespace App\Models;

use App\Models\BaseModel;

class Batch extends BaseModel
{
    protected $table = 'batches';

    protected $fillable = [
        'batch_number',
        'start_date',
        'end_date',
        'status',
        'quantity',
        'remarks',
        'is_active',
    ];

    public function details()
    {
        return $this->hasMany(BatchDetail::class, 'id_batch');
    }
}
