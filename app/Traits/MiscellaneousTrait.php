<?php

namespace App\Traits;
use App\Model\Miscellaneous;
use Auth;
trait MiscellaneousTrait{
	public function allMiscellaneous(){
		return Miscellaneous::orderBy('id','DESC')->get();
	}

	public function addMiscellaneous($request){
	$miscellaneous = new Miscellaneous();
        $miscellaneous->name = $request->name;
        $miscellaneous->address = $request->address;
        $miscellaneous->phone = $request->phone;
        $miscellaneous->amount = $request->amount;
        $miscellaneous->pay_by = $request->pay_by;
        $miscellaneous->payment_from = 1;
        $miscellaneous->date = date('Y-m-d H:i:s', strtotime($request->date));
        $miscellaneous->create_userid = Auth::user()->id;
        $miscellaneous->update_userid = Auth::user()->id;
        $miscellaneous->create_userip = $request->ip();
        $miscellaneous->update_userip = $request->ip();
        $miscellaneous->save();
	}

	public function editMiscellaneous($request, $id){
	$miscellaneous = Miscellaneous::find($id);
        $miscellaneous->name = $request->name;
        $miscellaneous->address = $request->address;
        $miscellaneous->phone = $request->phone;
        $miscellaneous->amount = $request->amount;
        $miscellaneous->pay_by = $request->pay_by;
        // $miscellaneous->payment_from = $request->payment_from;
        $miscellaneous->date =  date('Y-m-d H:i:s', strtotime($request->date));
        $miscellaneous->update_userid = Auth::user()->id;
        $miscellaneous->update_userip = $request->ip();
        $miscellaneous->save();
	}

        public function invoice($id){
                return Miscellaneous::find($id);
        }
}