<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApply extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'job_id',
        'date',
        'status',
    ];

    function candidate()   
    {
        return $this->belongsTo(Candidate::class)->select('id','name','email','mobile');
    }

    function job() 
    {
            return $this->belongsTo(PostJob::class)->select('id','job_title');
    }

}
