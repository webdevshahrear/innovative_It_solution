<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['client_name', 'client_position', 'client_image', 'content', 'rating', 'status', 'display_order'];

    /**
     * Accessors for backward compatibility with legacy view field names
     */
    public function getNameAttribute()
    {
        return $this->client_name;
    }

    public function getPositionAttribute()
    {
        return $this->client_position;
    }

    public function getImageAttribute()
    {
        return $this->client_image;
    }

    public function getCommentAttribute()
    {
        return $this->content;
    }
}
