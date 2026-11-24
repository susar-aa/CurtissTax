<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'business_id',
        'activity_type',
        'description',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public static function record(string $type, string $description, ?int $userId = null, ?int $businessId = null): self
    {
        $userId = $userId ?: (auth()->check() ? auth()->id() : null);
        $businessId = $businessId ?: (auth()->check() ? auth()->user()->current_business_id : null);

        return static::create([
            'user_id' => $userId,
            'business_id' => $businessId,
            'activity_type' => $type,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
