<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip_address',
        'login',
        'success',
        'time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'success' => 'boolean',
    ];

    /**
     * Get recent failed login attempts for a specific login (email/username)
     *
     * @param string $login
     * @return int
     */
    public static function getRecentFailedAttempts($login): int
    {
        // Get failed attempts in the last 30 minutes
        return self::where('login', $login)
            ->where('success', false)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->count();
    }

    /**
     * Get recent failed login attempts from an IP address
     *
     * @param string $ip
     * @return int
     */
    public static function getRecentFailedAttemptsFromIP($ip): int
    {
        // Get failed attempts in the last 30 minutes
        return self::where('ip_address', $ip)
            ->where('success', false)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->count();
    }
}
