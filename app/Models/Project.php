<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['client_id', 'title', 'slug', 'client_name', 'project_url', 'description', 'tags', 'desktop_image', 'mobile_image', 'featured', 'status', 'display_order'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function categories()
    {
        return $this->belongsToMany(ProjectCategory::class, 'project_category_relations', 'project_id', 'category_id');
    }
}
