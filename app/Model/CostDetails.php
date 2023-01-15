<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CostDetails extends Model
{
    // public function costname(){
    // 	return $this->belongsTo(CostName::class);
    // }
    public function costmaster(){
    	return $this->belongsTo(CostMaster::class);
    }
}
