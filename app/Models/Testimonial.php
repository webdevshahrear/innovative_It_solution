<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['client_name', 'client_position', 'client_image', 'content', 'rating', 'status', 'display_order'];
}
