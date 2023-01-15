<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdvTran extends Model
{
    public function history(){
    	return $this->belongsTo(History::class);
    }
    public function advice(){
    	return $this->belongsTo(Advi::class);
    }
}
