<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transcation extends Model
{
    protected $fillable=['from_id','to_id','transfer_type','amount'];
}
