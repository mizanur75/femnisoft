<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Advi extends Model
{
    public function advtran(){
    	return $this->hasOne(AdvTran::class);
    }
}
