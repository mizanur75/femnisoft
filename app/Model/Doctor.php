<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public function user(){
    	return $this->belongsTo('App\User');
    }
    public function chamber(){
    	return $this->belongsTo(Chamber::class);
    }
    public function patient_request(){
    	return $this->belongsTo(PatientRequest::class);
    }
    public function invoicemaster(){
    	return $this->hasMany(InvoiceMaster::class);
    }
    public function app_invoice(){
        return $this->hasMany(AppInvoice::class);
    }
}
