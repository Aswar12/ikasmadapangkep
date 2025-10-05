<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'coordinator_id',
        'logo',
    ];

    /**
     * Get the coordinator of the department.
     */
    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    /**
     * Get the department memberships.
     */
    public function departmentMembers()
    {
        return $this->hasMany(DepartmentMember::class);
    }

    /**
     * Get the users that belong to the department.
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'department_members')
                    ->withPivot('role_in_department', 'status', 'joined_at', 'resigned_at', 'notes')
                    ->withTimestamps();
    }

    /**
     * Get active members.
     */
    public function activeMembers()
    {
        return $this->members()->wherePivot('status', 'active');
    }

    /**
     * Get executive members (coordinator, secretary, treasurer).
     */
    public function executives()
    {
        return $this->members()->whereIn('department_members.role_in_department', ['coordinator', 'secretary', 'treasurer']);
    }

    /**
     * Get the program kerja for the department.
     */
    public function programKerja()
    {
        return $this->hasMany(ProgramKerja::class);
    }

    /**
     * Get active program kerja for the department.
     */
    public function activeProgramKerja()
    {
        return $this->hasMany(ProgramKerja::class)->where('status', 'ongoing');
    }

    /**
     * Get completed program kerja for the department.
     */
    public function completedProgramKerja()
    {
        return $this->hasMany(ProgramKerja::class)->where('status', 'completed');
    }

    /**
     * Calculate total budget for this department
     */
    public function getTotalBudgetAttribute()
    {
        return $this->programKerja->sum('budget');
    }

    /**
     * Calculate total realization for this department
     */
    public function getTotalRealizationAttribute()
    {
        return $this->programKerja->sum('realization');
    }

    /**
     * Calculate budget utilization percentage
     */
    public function getBudgetUtilizationAttribute()
    {
        $totalBudget = $this->total_budget;
        return $totalBudget > 0 ? ($this->total_realization / $totalBudget) * 100 : 0;
    }

    /**
     * Get program completion rate
     */
    public function getCompletionRateAttribute()
    {
        $totalPrograms = $this->programKerja->count();
        $completedPrograms = $this->completedProgramKerja->count();
        
        return $totalPrograms > 0 ? ($completedPrograms / $totalPrograms) * 100 : 0;
    }

    /**
     * Scope to get departments with their statistics
     */
    public function scopeWithStats($query)
    {
        return $query->withCount([
            'programKerja as total_programs',
            'activeProgramKerja as active_programs',
            'completedProgramKerja as completed_programs'
        ]);
    }
}
