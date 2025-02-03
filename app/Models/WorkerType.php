<?php

namespace App\Models;

class WorkerType extends BaseModel
{
    protected $table = 'worker_types';

    protected $fillable = [
        'worker_type',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'worker_worker_type', 'id_worker_type', 'id_worker')
            ->wherePivot('is_active', 'min_cost');
    }

    public function workerPrices()
    {
        return $this->hasMany(WorkerPrice::class, 'id_worker_type', 'id');
    }
}
