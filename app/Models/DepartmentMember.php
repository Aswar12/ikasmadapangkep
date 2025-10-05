<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'role_in_department',
        'status',
        'joined_at',
        'resigned_at',
        'notes'
    ];

    protected $casts = [
        'joined_at' => 'date',
        'resigned_at' => 'date',
    ];

    /**
     * Role names for display
     */
    public static function getRoleNames()
    {
        return [
            'coordinator' => 'Koordinator',
            'secretary' => 'Sekretaris',
            'treasurer' => 'Bendahara',
            'member' => 'Anggota',
            'volunteer' => 'Relawan'
        ];
    }

    /**
     * Status names for display
     */
    public static function getStatusNames()
    {
        return [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'resigned' => 'Mengundurkan Diri'
        ];
    }

    /**
     * Get the user that belongs to the department.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department that the user belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Check if member is coordinator
     */
    public function isCoordinator()
    {
        return $this->role_in_department === 'coordinator';
    }

    /**
     * Check if member is executive (coordinator, secretary, treasurer)
     */
    public function isExecutive()
    {
        return in_array($this->role_in_department, ['coordinator', 'secretary', 'treasurer']);
    }

    /**
     * Check if member is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Scope to get active members
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get executives
     */
    public function scopeExecutives($query)
    {
        return $query->whereIn('role_in_department', ['coordinator', 'secretary', 'treasurer']);
    }
}