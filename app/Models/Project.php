<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'slug', 'client_name', 'project_url', 'description', 'desktop_image', 'mobile_image', 'featured', 'status', 'display_order'];

    public function categories()
    {
        return $this->belongsToMany(ProjectCategory::class, 'project_category_relations', 'project_id', 'category_id');
    }
}
