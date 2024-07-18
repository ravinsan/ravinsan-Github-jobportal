<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recruiter_id',
        'job_title',
        'job_description',
        'status',
    ];

    function recruiter()
    {
        return $this->belongsTo(Recruiter::class);
    }
}
