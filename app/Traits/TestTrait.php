<?php

namespace App\Traits;
use App\Model\Test;
use Auth;
trait TestTrait{

	public function addTest($request){
        $test = new Test();
        $test->user_id = Auth::user()->id;
        $test->test_name = $request->name;
        $test->default_value = 0;
        $test->cost = $request->cost;
        $test->remark = $request->remark;
        $test->status = $request->status;
        $test->save();
	}

	public function editTest($request, $id){
        $test = Test::find($id);
        $test->user_id = Auth::user()->id;
        $test->test_name = $request->name;
        $test->default_value = 0;
        $test->cost = $request->cost;
        $test->remark = $request->remark;
        $test->status = $request->status;
        $test->save();
	}
}