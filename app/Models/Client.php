<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'linkedin_url',
        'website_url',
        'total_revenue',
        'status',
        'source_inquiry_id'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function sourceInquiry()
    {
        return $this->belongsTo(ContactSubmission::class, 'source_inquiry_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
