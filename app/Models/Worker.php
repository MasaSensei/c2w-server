<?php

namespace App\Models;

class Worker extends BaseModel
{
    protected $table = 'workers';

    protected $fillable = [
        'name',
        'contact',
        'address',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function workerTypes()
    {
        return $this->belongsToMany(WorkerType::class, 'worker_worker_type', 'id_worker', 'id_worker_type')
            ->withPivot('min_cost', 'is_active');
    }

    public function workerPrices()
    {
        return $this->hasMany(WorkerPrice::class, 'id_worker');
    }
}
