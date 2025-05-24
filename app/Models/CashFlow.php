<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type',
        'category_id',
        'amount',
        'transaction_date',
        'description',
        'receipt_image',
        'department_id',
        'program_kerja_id',
        'created_by',
        'approved_by',
        'approval_date',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'approval_date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(CashFlowCategory::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
