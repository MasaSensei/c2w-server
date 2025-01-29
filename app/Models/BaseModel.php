<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if (in_array(SoftDeletes::class, class_uses($model))) {
                $model->is_active = 0;
                $model->save();
            }
        });
    }
}
