<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SoftDeleteScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses($model))) {
            $builder->deleting(function (Model $model) {
                $model->is_active = 0;
                $model->save();
            });
        }
    }
}
