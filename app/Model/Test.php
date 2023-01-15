<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function report(){
    	return $this->hasOne(Report::class);
    }
    public function invoice_details(){
    	return $this->hasMany(InvoiceDetails::class);
    }
}
