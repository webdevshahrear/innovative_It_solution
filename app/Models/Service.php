<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['title', 'slug', 'icon_class', 'short_description', 'full_description', 'status', 'display_order'];
}
