<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientRequest extends Model
{
    public function doctor(){
    	return $this->hasMany(Doctor::class);
    }
    public function app_invoice(){
        return $this->hasMany(AppInvoice::class);
    }
}
