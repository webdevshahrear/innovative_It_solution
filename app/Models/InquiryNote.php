<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryNote extends Model
{
    protected $fillable = [
        'inquiry_id',
        'admin_id',
        'content',
        'type',
        'file_path',
        'file_name',
    ];

    public function inquiry()
    {
        return $this->belongsTo(ContactSubmission::class, 'inquiry_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
