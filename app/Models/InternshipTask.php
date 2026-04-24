<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_account_id', 'assigned_by', 'title', 'description',
        'deadline', 'priority', 'status', 'mentor_feedback', 'score', 'resources',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'score'    => 'decimal:2',
    ];

    public function internAccount()
    {
        return $this->belongsTo(InternshipAccount::class, 'intern_account_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function submission()
    {
        return $this->hasOne(InternshipTaskSubmission::class, 'task_id');
    }

    public function isOverdue(): bool
    {
        return $this->deadline
            && $this->deadline->isPast()
            && !in_array($this->status, ['submitted', 'reviewed', 'approved']);
    }

    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'danger',
            'high'   => 'warning',
            'medium' => 'info',
            'low'    => 'secondary',
            default  => 'secondary',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'secondary',
            'in_progress' => 'info',
            'submitted'   => 'primary',
            'reviewed'    => 'warning',
            'approved'    => 'success',
            'rejected'    => 'danger',
            default       => 'secondary',
        };
    }
}
