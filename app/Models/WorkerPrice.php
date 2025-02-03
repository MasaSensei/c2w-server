<?php

namespace App\Models;

class WorkerPrice extends BaseModel
{
    protected $table = 'material_worker_prices';
    protected $fillable = [
        'id_worker',
        'id_worker_type',
        'id_item_category',
        'min_cost',
        'cost_per_yard',
        'is_active',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'id_worker');
    }

    public function workerType()
    {
        return $this->belongsTo(WorkerType::class, 'id_worker_type');
    }

    public function materialCategory()
    {
        return $this->belongsTo(Category::class, 'id_item_category');
    }
}
