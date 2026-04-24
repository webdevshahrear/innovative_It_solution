<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InternshipExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id', 'category_id', 'session_token', 'ip_address',
        'started_at', 'submitted_at', 'terminated_at',
        'total_questions', 'correct_answers', 'score_percentage',
        'tab_switch_count', 'status',
    ];

    protected $casts = [
        'started_at'    => 'datetime',
        'submitted_at'  => 'datetime',
        'terminated_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(InternshipApplication::class, 'application_id');
    }

    public function category()
    {
        return $this->belongsTo(InternshipCategory::class, 'category_id');
    }

    public function answers()
    {
        return $this->hasMany(InternshipExamAnswer::class, 'attempt_id');
    }

    public function tabViolations()
    {
        return $this->hasMany(InternshipTabViolation::class, 'attempt_id');
    }

    public function payment()
    {
        return $this->hasOne(InternshipPayment::class, 'attempt_id');
    }

    public function isPassed(): bool
    {
        return $this->status === 'passed';
    }

    public function isTerminated(): bool
    {
        return $this->status === 'terminated';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function getWrongAnswersAttribute(): int
    {
        return $this->total_questions - $this->correct_answers;
    }

    public static function generateSessionToken(): string
    {
        return Str::uuid()->toString();
    }
}
