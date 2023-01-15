<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function patient_info(){
    	return $this->hasMany(PatientInfo::class);
    }
    public function invoicemaster(){
    	return $this->hasMany(InvoiceMaster::class);
    }
    public function app_invoice(){
        return $this->hasMany(AppInvoice::class);
    }
    public function address(){
    	return $this->belongsTo(Address::class);
    }
}
