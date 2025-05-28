<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'payment_date',
        'payment_method',
        'payment_proof',
        'year_period',
        'notes',
        'verified_by',
        'verification_date'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'verification_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user who made the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who verified the payment.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get status label with color.
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'sudah_lunas':
                return '<span class="badge bg-success">Lunas</span>';
            case 'menunggu_verifikasi':
                return '<span class="badge bg-warning">Menunggu Verifikasi</span>';
            default:
                return '<span class="badge bg-danger">Belum Bayar</span>';
        }
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
