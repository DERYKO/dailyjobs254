<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable=['job_id','applicant_id','job_owner_id','cover_letter','accepted'];

    public function job(){
        return $this->belongsTo(Job::class);
    }
    public function applicant(){
        $this->belongsTo(User::class,'applicant_id');
    }
}
