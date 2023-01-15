<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    public function advt(){
    	return $this->hasMany(AdvTran::class);
    }

    public function invoiceMaster(){
    	return $this->hasOne(InvoiceMaster::class);
    }
    public function patient_info(){
    	return $this->belongsTo(PatientInfo::class);
    }
}
