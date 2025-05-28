<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'position',
        'description',
        'requirements',
        'location',
        'salary_min',
        'salary_max',
        'is_salary_disclosed',
        'application_deadline',
        'application_link',
        'contact_email',
        'contact_phone',
        'company_logo',
        'is_active'
    ];

    protected $casts = [
        'is_salary_disclosed' => 'boolean',
        'is_active' => 'boolean',
        'application_deadline' => 'date',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    /**
     * Get the user who posted the job.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get only active jobs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('application_deadline', '>', now());
    }

    /**
     * Get formatted salary range.
     */
    public function getSalaryRangeAttribute()
    {
        if (!$this->is_salary_disclosed) {
            return 'Tidak disebutkan';
        }

        if ($this->salary_min && $this->salary_max) {
            return 'Rp ' . number_format($this->salary_min) . ' - Rp ' . number_format($this->salary_max);
        } elseif ($this->salary_min) {
            return 'Minimal Rp ' . number_format($this->salary_min);
        } elseif ($this->salary_max) {
            return 'Maksimal Rp ' . number_format($this->salary_max);
        }

        return 'Negotiable';
    }
}
