<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'email',
        'role',
        'token',
        'invited_by_user_id',
        'expires_at',
        'accepted_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by_user_id');
    }

    public function isExpired(): bool
    {
        return now()->isAfter($this->expires_at);
    }

    public function isAccepted(): bool
    {
        return !is_null($this->accepted_at);
    }
}
