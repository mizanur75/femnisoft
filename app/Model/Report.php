<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];

    public function test(){
    	return $this->belongsTo(Test::class);
    }
}
