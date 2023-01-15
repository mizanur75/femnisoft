<?php

namespace App\Traits;
use App\Model\Expend;
use Auth;
trait ExpendTrait{
	public function allExpend(){
		return Expend::orderBy('id','DESC')->get();
	}

	public function addExpend($request){
        	if ($request->req_type == 1) {

                    $costname = new CostName();
                    $costname->user_id = Auth::user()->id;
                    $costname->cost_name = $request->name;
                    $costname->comments = $request->comments;
                    $costname->save();

                }elseif($request->req_type == 2){
                    $costMaster = new Expend();
                    $costMaster->cost_name_id = $request->cost_name_id;
                    $costMaster->description = $request->description;
                    $costMaster->amount = $request->amount;
                    $costMaster->date = date('Y-m-d H:i:s', strtotime($request->cost_date));
                    $costMaster->create_user_id = Auth::user()->id;
                    $costMaster->update_user_id = Auth::user()->id;
                    $costMaster->create_user_ip = $request->ip();
                    $costMaster->update_user_ip = $request->ip();
                    $costMaster->save();
                }
	}

	public function editExpend($request, $id){
        	if ($request->req_type == 1) {
                    $costname = CostName::find($id);
                    $costname->user_id = Auth::user()->id;
                    $costname->cost_name = $request->name;
                    $costname->comments = $request->comments;
                    $costname->status = $request->status;
                    $costname->save();
                }elseif($request->req_type == 2){
                    $costMaster = Expend::find($id);
                    $costMaster->cost_name_id = $request->cost_name_id;
                    $costMaster->description = $request->description;
                    $costMaster->amount = $request->amount;
                    $costMaster->date = date('Y-m-d H:i:s', strtotime($request->cost_date));
                    $costMaster->update_user_id = Auth::user()->id;
                    $costMaster->update_user_ip = $request->ip();
                    $costMaster->save();
                }
	}

        public function invoice($id){
                return Expend::find($id);
        }
}