<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'application_id', 'category_id', 'mentor_id',
        'registration_token', 'start_date', 'end_date',
        'status', 'performance_score',
    ];

    protected $casts = [
        'start_date'        => 'date',
        'end_date'          => 'date',
        'performance_score' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function application()
    {
        return $this->belongsTo(InternshipApplication::class, 'application_id');
    }

    public function category()
    {
        return $this->belongsTo(InternshipCategory::class, 'category_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function tasks()
    {
        return $this->hasMany(InternshipTask::class, 'intern_account_id');
    }

    public function pendingTasks()
    {
        return $this->tasks()->whereIn('status', ['pending', 'in_progress']);
    }

    public function submittedTasks()
    {
        return $this->tasks()->where('status', 'submitted');
    }

    public function approvedTasks()
    {
        return $this->tasks()->where('status', 'approved');
    }

    public function certificate()
    {
        return $this->hasOne(InternshipCertificate::class, 'intern_account_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getPerformanceGradeAttribute(): string
    {
        $score = $this->performance_score;
        if ($score >= 90) return 'A+';
        if ($score >= 80) return 'A';
        if ($score >= 70) return 'B+';
        if ($score >= 60) return 'B';
        if ($score >= 50) return 'C';
        return 'D';
    }

    public function getCertificateEligibilityAttribute(): bool
    {
        return $this->performance_score >= 60
            && $this->approved_tasks_count >= 5
            && $this->status === 'active';
    }
}
