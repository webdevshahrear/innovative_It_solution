<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = ['name', 'position', 'bio', 'image', 'status', 'display_order', 'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url'];
}
