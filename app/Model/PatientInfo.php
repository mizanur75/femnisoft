<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientInfo extends Model
{
    public function invs(){
    	return $this->hasMany(Inv::class);
    }

    public function finvs(){
    	return $this->hasMany(Finv::class);
    }

    public function patient(){
    	return $this->belongsTo(Patient::class);
    }
    public function history(){
    	return $this->hasOne(History::class);
    }
}
