<?php

namespace App\Models;

use App\Traits\BelongsToBusiness;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory, BelongsToBusiness;

    protected $fillable = [
        'business_id',
        'code',
        'name',
        'phone',
        'email',
        'address',
        'is_main',
        'is_active',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'is_active' => 'boolean',
    ];
}
