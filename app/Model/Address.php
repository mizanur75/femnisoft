<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function patient(){
    	return $this->hasOne(Patient::class);
    }
}
