<?php

namespace App\Traits;

use App\Models\Business;
use App\Scopes\TenantScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToBusiness
{
    public static function bootBelongsToBusiness(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            if (empty($model->business_id)) {
                if (app()->has('current_business_id')) {
                    $model->business_id = app('current_business_id');
                } elseif (Auth::check() && Auth::user()->current_business_id) {
                    $model->business_id = Auth::user()->current_business_id;
                }
            }
        });
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
