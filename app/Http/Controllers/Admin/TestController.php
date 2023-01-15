<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Test;
use Illuminate\Http\Request;
use Auth;

class TestController extends Controller
{

    public function index()
    {
        $tests = Test::orderBy('id','DESC')->get();
        return view('admin.test.all', compact('tests'));
    }


    public function create()
    {
        return view('admin.test.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'default_value' => 'required',
        ]);

        $test = new Test();
        $test->user_id = Auth::user()->id;
        $test->test_name = $request->name;
        $test->default_value = $request->default_value;
        $test->remark = $request->remark;
        $test->status = $request->status;
        $test->save();

        return redirect()->route('admin.test.index')->with('success','Test Added!');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $test = Test::find($id);
        return view('admin.test.edit', compact('test'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'default_value' => 'required',
        ]);

        $test = Test::find($id);
        $test->user_id = Auth::user()->id;
        $test->test_name = $request->name;
        $test->default_value = $request->default_value;
        $test->remark = $request->remark;
        $test->status = $request->status;
        $test->save();

        return redirect()->route('admin.test.index')->with('success','Test Updated!');
    }

    public function destroy($id)
    {
        $test = Test::find($id);
        $test->delete();
        return back()->with('success','Test Deleted!');
    }
}
