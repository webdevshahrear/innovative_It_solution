<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipNotice extends Model
{
    use HasFactory;

    protected $fillable = [
        'posted_by', 'title', 'content', 'target_audience',
        'target_category_id', 'is_pinned', 'published_at',
    ];

    protected $casts = [
        'is_pinned'    => 'boolean',
        'published_at' => 'datetime',
    ];

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function targetCategory()
    {
        return $this->belongsTo(InternshipCategory::class, 'target_category_id');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }
}
