<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramKerjaUpdate; // Added this line

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
        'realization',
        'pic_id',
        'progress',
        'status',
        'notes'
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
        'realization' => 'decimal:2',
        'progress' => 'integer',
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
        return $this->hasMany(ProgramKerjaUpdate::class)->orderBy('update_date', 'desc');
    }

    /**
     * Get the PIC user for the program.
     */
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}
