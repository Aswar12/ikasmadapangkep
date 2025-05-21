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
     * Get the users that belong to the department.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_departments')
                    ->withPivot('role_in_department')
                    ->withTimestamps();
    }

    /**
     * Get the program kerja for the department.
     */
    public function programKerja()
    {
        return $this->hasMany(ProgramKerja::class);
    }
}
