<?php

namespace App\Traits;
use App\Model\Donate;
use Auth;
trait DonateTrait{
	public function allDonate(){
		return Donate::orderBy('id','DESC')->get();
	}

	public function addDonate($request){
	$donate = new Donate();
        $donate->name = $request->name;
        $donate->address = $request->address;
        $donate->phone = $request->phone;
        $donate->amount = $request->amount;
        $donate->pay_by = $request->pay_by;
        $donate->payment_from = $request->payment_from;
        $donate->donate_date = date('Y-m-d H:i:s', strtotime($request->date));
        $donate->create_userid = Auth::user()->id;
        $donate->update_userid = Auth::user()->id;
        $donate->create_userip = $request->ip();
        $donate->update_userip = $request->ip();
        $donate->save();
	}

	public function editDonate($request, $id){
	$donate = Donate::find($id);
        $donate->name = $request->name;
        $donate->address = $request->address;
        $donate->phone = $request->phone;
        $donate->amount = $request->amount;
        $donate->pay_by = $request->pay_by;
        $donate->payment_from = $request->payment_from;
        $donate->donate_date =  date('Y-m-d H:i:s', strtotime($request->date));
        $donate->update_userid = Auth::user()->id;
        $donate->update_userip = $request->ip();
        $donate->save();
	}

        public function invoice($id){
                return Donate::find($id);
        }
}