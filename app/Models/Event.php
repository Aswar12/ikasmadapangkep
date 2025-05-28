<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'event_title',
        'event_slug',
        'description',
        'event_date',
        'location',
        'ticket_price',
        'quota',
        'poster_image',
        'created_by',
        'posting_date'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'posting_date' => 'datetime',
        'ticket_price' => 'decimal:2',
    ];

    /**
     * Get the user who created the event.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all registrations for the event.
     */
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Check if a user is registered for this event.
     */
    public function isRegisteredBy($userId)
    {
        return $this->registrations()->where('user_id', $userId)->exists();
    }

    /**
     * Get the registration count.
     */
    public function getRegistrationCountAttribute()
    {
        return $this->registrations()->count();
    }

    /**
     * Check if event is full.
     */
    public function getIsFullAttribute()
    {
        return $this->quota && $this->registration_count >= $this->quota;
    }
}
