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
        'email',
        'success',
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
     * Get recent failed login attempts for the given email.
     *
     * @param string $email
     * @param int $minutes
     * @return int
     */
    public static function getRecentFailedAttempts($email, $minutes = 30)
    {
        return static::where('email', $email)
            ->where('success', false)
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->count();
    }
}
