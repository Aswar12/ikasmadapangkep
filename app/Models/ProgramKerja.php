<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    use HasFactory;

    protected $table = 'programs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'location',
        'budget',
        'status',
        'progress_percentage',
        'current_progress'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'progress_percentage' => 'integer',
    ];

    /**
     * Get the department that owns the program.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the updates for the program.
     */
    public function updates()
    {
        return $this->hasMany(ProgramKerjaUpdate::class);
    }

    /**
     * Get the PIC user for the program.
     */
    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }
}
