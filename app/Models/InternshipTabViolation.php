<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipTabViolation extends Model
{
    use HasFactory;

    protected $fillable = ['attempt_id', 'violation_type', 'occurred_at'];

    protected $casts = ['occurred_at' => 'datetime'];

    public function attempt()
    {
        return $this->belongsTo(InternshipExamAttempt::class, 'attempt_id');
    }
}
