<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Chamber extends Model
{
    public function doctor(){
    	return $this->hasMany(Doctor::class);
    }
}
