<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    public function invoicemaster(){
    	return $this->belongsTo(InvoiceMaster::class);
    }
    public function test(){
    	return $this->belongsTo(Test::class);
    }
}
