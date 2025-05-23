<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if the user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Check if the user is an admin (including sub-admin).
     */
    public function isAdmin(): bool
    {
        return $this->hasAnyRole(['admin', 'sub_admin']);
    }

    /**
     * Check if the user is a department coordinator.
     */
    public function isDepartmentCoordinator(): bool
    {
        return $this->hasRole('department_coordinator');
    }

    /**
     * Check if the user is a regular alumni.
     */
    public function isAlumni(): bool
    {
        return $this->hasRole('alumni');
    }

    /**
     * Find user by login identifier (email, username, or phone)
     */
    public static function findForLogin($login)
    {
        return static::where('email', $login)
            ->orWhere('username', $login)
            ->orWhere('phone', $login)
            ->first();
    }

    /**
     * Custom login validation rules
     */
    public static function loginValidationRules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Custom registration validation rules
     */
    public static function registrationValidationRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users',
                'regex:/^[a-zA-Z0-9_-]+$/',
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => [
                'required',
                'string',
                'max:20',
                'unique:users',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'
            ],
            'graduation_year' => ['required', 'string', 'max:4'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'current_job' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get the validation error messages.
     */
    public static function validationMessages(): array
    {
        return [
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username hanya boleh berisi huruf, angka, tanda hubung (-), dan garis bawah (_).',
            'email.unique' => 'Email sudah digunakan.',
            'phone.unique' => 'Nomor WhatsApp sudah digunakan.',
            'phone.regex' => 'Format nomor WhatsApp tidak valid. Gunakan format: 08xx atau +62xx.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'graduation_year.required' => 'Tahun kelulusan wajib diisi.',
        ];
    }
}
