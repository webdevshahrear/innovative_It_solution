<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = ['title', 'subtitle', 'image_path', 'button_text', 'button_link', 'status', 'display_order'];
}
