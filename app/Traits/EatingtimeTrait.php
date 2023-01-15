<?php

namespace App\Traits;
use App\Model\EatingTime;
use Auth;
trait EatingtimeTrait{

	public function addEatingtime($request){
        $eatingtime = new EatingTime();
        $eatingtime->name = $request->eating_time;
        $eatingtime->status = 0;
        $eatingtime->save();
	}

	public function editEatingtime($request, $id){
        $eatingtime = EatingTime::find($id);
        $eatingtime->name = $request->eating_time;
        $eatingtime->status = 0;
        $eatingtime->save();
	}
}