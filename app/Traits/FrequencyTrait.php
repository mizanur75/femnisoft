<?php

namespace App\Traits;
use App\Model\Frequency;
use Auth;
trait FrequencyTrait{

	public function addFrequency($request){
        $frequency = new Frequency();
        $frequency->name = $request->frequency;
        $frequency->status = 0;
        $frequency->save();
	}

	public function editFrequency($request, $id){

        $frequency = Frequency::find($id);
        $frequency->name = $request->frequency;
        $frequency->status = 0;
        $frequency->save();
	}
}