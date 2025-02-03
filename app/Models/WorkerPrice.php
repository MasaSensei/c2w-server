<?php

namespace App\Models;

class WorkerPrice extends BaseModel
{
    protected $fillable = [
        'worker_type_id',
        'material_category_id',
        'min_cost',
        'price_per_yard',
    ];

    public function workerType()
    {
        return $this->belongsTo(WorkerType::class, 'id_worker_type');
    }

    public function materialCategory()
    {
        return $this->belongsTo(Category::class, 'id_material_category');
    }
}
