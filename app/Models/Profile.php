<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_photo',  // Added profile_photo column
        'gender',
        'birth_place',
        'birth_date',
        'national_student_number',
        'address',
        'phone_number',
        'father_name',
        'father_occupation',
        'mother_name',
        'mother_occupation',
        'entry_year',
        'graduation_year',
        'diploma_number',
        'certificate_number'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
