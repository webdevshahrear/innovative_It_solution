<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['attempt_id', 'question_id', 'selected_option', 'is_correct'];

    protected $casts = ['is_correct' => 'boolean'];

    public function attempt()
    {
        return $this->belongsTo(InternshipExamAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(InternshipExamQuestion::class, 'question_id');
    }
}
