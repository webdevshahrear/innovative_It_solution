<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_account_id', 'issued_by', 'certificate_number',
        'category_name', 'performance_grade', 'pdf_path', 'issued_at',
    ];

    protected $casts = ['issued_at' => 'datetime'];

    public function internAccount()
    {
        return $this->belongsTo(InternshipAccount::class, 'intern_account_id');
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
