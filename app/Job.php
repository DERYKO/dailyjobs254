<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
   protected  $fillable=['active','latitude','longitude','title','owner_id','description','rules','start_time','duration','pay_amount','job_location_address'];

    public function categories(){
        return $this->hasMany(UserCategory::class);
    }
    public function applications(){
        return $this->hasMany(Application::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'owner_id','id');
    }
    public function forecast(){
        return $this->hasMany(Forecast::class,'job_id','id');
    }
}
