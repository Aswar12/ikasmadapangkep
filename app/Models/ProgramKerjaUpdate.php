<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKerjaUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_kerja_id',
        'user_id',
        'update_description',
        'progress_percentage',
        'document_path',
        'update_date',
        'updated_by',
    ];

    protected $casts = [
        'update_date' => 'date',
        'progress_percentage' => 'integer',
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
