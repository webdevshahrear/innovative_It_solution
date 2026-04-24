<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Role Helpers ──
    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isMentor(): bool  { return $this->role === 'mentor'; }
    public function isIntern(): bool  { return $this->role === 'intern'; }

    // ── Internship Relationships ──
    public function internAccount()
    {
        return $this->hasOne(InternshipAccount::class, 'user_id');
    }

    public function mentorInterns()
    {
        return $this->hasMany(InternshipAccount::class, 'mentor_id');
    }

    public function assignedTasks()
    {
        return $this->hasMany(InternshipTask::class, 'assigned_by');
    }

    public function postedNotices()
    {
        return $this->hasMany(InternshipNotice::class, 'posted_by');
    }
}
