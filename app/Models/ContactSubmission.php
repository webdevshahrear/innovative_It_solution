<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'linkedin_url',
        'website_url',
        'subject',
        'message',
        'lead_value',
        'ip_address',
        'user_agent',
        'status',
        'remind_at',
        'priority',
        'assigned_to',
    ];

    protected $casts = [
        'remind_at' => 'datetime',
    ];

    public function notes()
    {
        return $this->hasMany(InquiryNote::class, 'inquiry_id');
    }

    public function activities()
    {
        return $this->hasMany(CrmActivity::class, 'inquiry_id')->latest();
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function convertedClient()
    {
        return $this->hasOne(Client::class, 'source_inquiry_id');
    }
}
