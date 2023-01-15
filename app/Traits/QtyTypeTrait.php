<?php

namespace App\Traits;
use App\Model\QtyType;
use Auth;
trait QtyTypeTrait{

	public function addQtyType($request){
        $qtytype = new QtyType();
        $qtytype->name = $request->qty_type;
        $qtytype->status = 0;
        $qtytype->save();
	}

	public function editQtyType($request, $id){
        $qtytype = QtyType::find($id);
        $qtytype->name = $request->qty_type;
        $qtytype->status = 0;
        $qtytype->save();
	}
}