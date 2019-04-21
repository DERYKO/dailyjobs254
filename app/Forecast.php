<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    protected $fillable=['time','icon_code','prediction','job_id'];

    public function job(){
        return $this->belongsTo(Job::class);
    }
}
