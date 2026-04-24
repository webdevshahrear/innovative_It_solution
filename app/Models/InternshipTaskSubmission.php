<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipTaskSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id', 'submission_text', 'file_paths', 'live_url', 'github_url', 'submitted_at',
    ];

    protected $casts = [
        'file_paths'   => 'array',
        'submitted_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(InternshipTask::class, 'task_id');
    }
}
