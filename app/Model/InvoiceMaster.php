<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoiceMaster extends Model
{
    public function invoicedetails(){
    	return $this->hasMany(InvoiceDetails::class);
    }
    public function patient(){
    	return $this->belongsTo(Patient::class);
    }
    public function doctor(){
    	return $this->belongsTo(Doctor::class);
    }
    public function history(){
    	return $this->belongsTo(History::class);
    }
}
