<?php

namespace App\Traits;
use App\Model\Qty;
use Auth;
trait QtyTrait{

	public function addQty($request){
        $qty = new Qty();
        $qty->name = $request->qty;
        $qty->status = 0;
        $qty->save();
	}

	public function editQty($request, $id){
        $qty = Qty::find($id);
        $qty->name = $request->qty;
        $qty->status = 0;
        $qty->save();
	}
}