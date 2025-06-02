<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_code',
        'year',
        'amount',
        'payment_method',
        'payment_proof',
        'status',
        'verified_by',
        'verified_at',
        'paid_at',
        'notes',
        'rejection_reason'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
        'amount' => 'decimal:2',
        'year' => 'integer'
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
            case 'verified':
                return '<span class="badge bg-success">Terverifikasi</span>';
            case 'waiting_verification':
                return '<span class="badge bg-warning">Menunggu Verifikasi</span>';
            case 'rejected':
                return '<span class="badge bg-danger">Ditolak</span>';
            case 'pending':
            default:
                return '<span class="badge bg-secondary">Belum Bayar</span>';
        }
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case 'verified':
                return 'bg-green-100 text-green-800';
            case 'waiting_verification':
                return 'bg-yellow-100 text-yellow-800';
            case 'rejected':
                return 'bg-red-100 text-red-800';
            case 'pending':
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'verified':
                return 'Terverifikasi';
            case 'waiting_verification':
                return 'Menunggu Verifikasi';
            case 'rejected':
                return 'Ditolak';
            case 'pending':
            default:
                return 'Belum Bayar';
        }
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Generate unique payment code
     */
    public static function generatePaymentCode()
    {
        do {
            $code = 'PAY-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        } while (self::where('payment_code', $code)->exists());
        
        return $code;
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for waiting verification
     */
    public function scopeWaitingVerification($query)
    {
        return $query->where('status', 'waiting_verification');
    }

    /**
     * Scope for verified payments
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope for rejected payments
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check if payment can be verified
     */
    public function canBeVerified()
    {
        return $this->status === 'waiting_verification' && $this->payment_proof;
    }

    /**
     * Check if payment is editable
     */
    public function isEditable()
    {
        return in_array($this->status, ['pending', 'rejected']);
    }

    /**
     * Get payment proof URL
     */
    public function getPaymentProofUrlAttribute()
    {
        if (!$this->payment_proof) {
            return null;
        }

        // Check if file exists in storage
        if (\Storage::disk('public')->exists($this->payment_proof)) {
            return asset('storage/' . $this->payment_proof);
        }

        return null;
    }
}
