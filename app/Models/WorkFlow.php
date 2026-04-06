<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkFlow extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon_class',
        'display_order',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }
}

