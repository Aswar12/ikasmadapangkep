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
        'is_active',
    ];

    protected $casts = [
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'is_salary_disclosed' => 'boolean',
        'application_deadline' => 'date',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
