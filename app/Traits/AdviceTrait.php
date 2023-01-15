<?php

namespace App\Traits;
use App\Model\Advi;
use Auth;
trait AdviceTrait{

	public function addAdvice($request){
	$advice = new Advi();
        $advice->name = $request->name;
        $advice->status = $request->status;
        $advice->save();
	}

	public function editAdvice($request, $id){
        $advice = Advi::find($id);
        $advice->name = $request->name;
        $advice->status = $request->status;
        $advice->save();
	}
}