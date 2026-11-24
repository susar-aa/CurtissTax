<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'user_id',
        'role',
        'is_owner',
        'status',
        'permissions',
    ];

    protected $casts = [
        'is_owner' => 'boolean',
        'permissions' => 'array',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
