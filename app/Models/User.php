<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'graduation_year',
        'role',
        'active',
        'approved',
        'approved_at',
        'approved_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'approved_at' => 'datetime',
        'active' => 'boolean',
        'approved' => 'boolean',
    ];

    /**
     * Get the profile associated with the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the alumni status associated with the user.
     */
    public function alumniStatus()
    {
        return $this->hasOne(AlumniStatus::class);
    }

    /**
     * Get the groups that the user belongs to.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_groups')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get the departments that the user belongs to.
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_departments')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a sub-admin.
     */
    public function isSubAdmin()
    {
        return $this->role === 'sub_admin';
    }

    /**
     * Check if user is a department coordinator.
     */
    public function isDepartmentCoordinator()
    {
        return $this->role === 'department_coordinator';
    }

    /**
     * Check if user is an alumni.
     */
    public function isAlumni()
    {
        return $this->role === 'alumni';
    }

    /**
     * Check if user is approved.
     */
    public function isApproved()
    {
        return $this->approved;
    }

    /**
     * Check if user is active.
     */
    public function isActive()
    {
        return $this->active;
    }
}
