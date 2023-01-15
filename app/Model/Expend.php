<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Expend extends Model
{
    public function costname(){
    	return $this->belongsTo(CostName::class);
    }
}
