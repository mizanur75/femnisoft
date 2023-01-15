<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Finv extends Model
{
	protected $guarded = [];
	
    public function patientinfo(){
    	return $this->belongsTo(PatientInfo::class);
    }
}
