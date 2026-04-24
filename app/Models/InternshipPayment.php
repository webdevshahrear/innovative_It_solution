<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id', 'attempt_id', 'amount', 'currency',
        'tran_id', 'val_id', 'payment_method', 'status',
        'gateway_response', 'bkash_number', 'bkash_transaction_id', 'paid_at',
    ];

    protected $casts = [
        'gateway_response' => 'array',
        'paid_at'          => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(InternshipApplication::class, 'application_id');
    }

    public function attempt()
    {
        return $this->belongsTo(InternshipExamAttempt::class, 'attempt_id');
    }

    public function isSuccess(): bool
    {
        return $this->status === 'success';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'success'   => 'success',
            'failed'    => 'danger',
            'cancelled' => 'warning',
            default     => 'secondary',
        };
    }
}
