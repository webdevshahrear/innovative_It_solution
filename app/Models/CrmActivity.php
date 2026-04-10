<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrmActivity extends Model
{
    protected $fillable = [
        'inquiry_id',
        'user_id',
        'type',
        'description',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function inquiry()
    {
        return $this->belongsTo(ContactSubmission::class, 'inquiry_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
