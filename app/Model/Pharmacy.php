<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    public function user(){
    	return $this->belongsTo('App\User');
    }
}
