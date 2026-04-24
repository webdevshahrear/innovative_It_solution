<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'description', 'is_active', 'display_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function applications()
    {
        return $this->hasMany(InternshipApplication::class, 'preferred_category_id');
    }

    public function questions()
    {
        return $this->hasMany(InternshipExamQuestion::class, 'category_id');
    }

    public function approvedQuestions()
    {
        return $this->questions()->where('is_approved', true);
    }

    public function attempts()
    {
        return $this->hasMany(InternshipExamAttempt::class, 'category_id');
    }

    public function accounts()
    {
        return $this->hasMany(InternshipAccount::class, 'category_id');
    }
}
