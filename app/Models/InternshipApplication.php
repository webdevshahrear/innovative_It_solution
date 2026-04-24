<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'father_name', 'mother_name', 'dob', 'gender', 'blood_group',
        'nid_birth_number', 'district', 'phone', 'email', 'address', 'permanent_address',
        'education', 'institute_name', 'passing_year', 'current_status',
        'preferred_category_id', 'secondary_category_id', 'skills', 'portfolio_url',
        'linkedin_url', 'cv_path', 'photo_path', 'motivation', 'available_hours', 'has_laptop', 'has_internet',
        'emergency_contact_name', 'emergency_contact_relationship', 'emergency_contact_phone',
        'status', 'admin_notes', 'terms_accepted', 'terms_accepted_at',
    ];

    protected $casts = [
        'dob'              => 'date',
        'has_laptop'       => 'boolean',
        'has_internet'     => 'boolean',
        'terms_accepted'   => 'boolean',
        'terms_accepted_at' => 'datetime',
    ];

    public function preferredCategory()
    {
        return $this->belongsTo(InternshipCategory::class, 'preferred_category_id');
    }

    public function secondaryCategory()
    {
        return $this->belongsTo(InternshipCategory::class, 'secondary_category_id');
    }

    public function examAttempts()
    {
        return $this->hasMany(InternshipExamAttempt::class, 'application_id');
    }

    public function latestAttempt()
    {
        return $this->hasOne(InternshipExamAttempt::class, 'application_id')->latestOfMany();
    }

    public function payments()
    {
        return $this->hasMany(InternshipPayment::class, 'application_id');
    }

    public function account()
    {
        return $this->hasOne(InternshipAccount::class, 'application_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'       => 'warning',
            'reviewed'      => 'info',
            'terms_accepted' => 'primary',
            'exam_passed'   => 'success',
            'exam_failed'   => 'danger',
            'paid'          => 'success',
            'active'        => 'success',
            'rejected'      => 'danger',
            default         => 'secondary',
        };
    }
}
