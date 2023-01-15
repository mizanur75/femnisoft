<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AppInvoice extends Model
{
    public function doctor(){
    	return $this->belongsTo(Doctor::class);
    }
    public function patient(){
    	return $this->belongsTo(Patient::class);
    }
    public function patient_request(){
    	return $this->belongsTo(PatientRequest::class);
    }
}
