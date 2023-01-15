<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Test;
use App\Traits\TestTrait;
use Auth;

class TestController extends Controller
{
    use TestTrait;
    public function index()
    {
        $tests = Test::orderBy('id','DESC')->get();
        return view('view.test.all', compact('tests'));
    }


    public function create()
    {
        return view('view.test.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'cost' => 'required',
            // 'default_value' => 'required',
        ]);

        $this->addTest($request);

        return redirect()->route('doctor.test.index')->with('success','Test Added!');
    }


    public function show($id)
    {
        //
    }


    public function edit($iid)
    {
        $id = \Crypt::decrypt($iid);
        $test = Test::find($id);
        return view('view.test.edit', compact('test'));
    }

    public function update(Request $request, $iid)
    {
        $id = \Crypt::decrypt($iid);
        $this->validate($request, [
            'name' => 'required',
            'cost' => 'required',
            // 'default_value' => 'required',
        ]);

        $this->editTest($request, $id);
        return redirect()->route('doctor.test.index')->with('success','Test Updated!');
    }

    public function destroy($id)
    {
        $test = Test::find($id);
        $test->delete();
        return back()->with('success','Test Deleted!');
    }
}
