<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d',
        'correct_option', 'explanation', 'difficulty', 'is_approved', 'generated_by', 'admin_notes',
    ];

    protected $casts = ['is_approved' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(InternshipCategory::class, 'category_id');
    }

    public function answers()
    {
        return $this->hasMany(InternshipExamAnswer::class, 'question_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeForCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function getOptionsAttribute(): array
    {
        return [
            'a' => $this->option_a,
            'b' => $this->option_b,
            'c' => $this->option_c,
            'd' => $this->option_d,
        ];
    }
}
