<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     * Enforces strict multi-tenant isolation by tenant business_id.
     */
    public function apply(Builder $builder, Model $model)
    {
        if (app()->runningInConsole() && !app()->has('current_business_id')) {
            return;
        }

        $businessId = null;

        if (app()->has('current_business_id')) {
            $businessId = app('current_business_id');
        } elseif (Auth::check() && Auth::user()->current_business_id) {
            $businessId = Auth::user()->current_business_id;
        }

        if ($businessId) {
            $builder->where($model->getTable() . '.business_id', $businessId);
        }
    }
}
