<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CostMaster extends Model
{
    public function costdetails(){
    	return $this->hasMany(CostDetails::class);
    }
}
