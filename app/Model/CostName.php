<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CostName extends Model
{
    public function costdetails(){
    	return $this->hasOne(CostDetails::class);
    }

    public function expends(){
    	return $this->hasMany(Expend::class);
    }
}
