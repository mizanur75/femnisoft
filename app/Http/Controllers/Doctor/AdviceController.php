<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Advi;
use App\Traits\AdviceTrait;

class AdviceController extends Controller
{
    use AdviceTrait;
    public function index()
    {
        $advices = Advi::orderBy('id','DESC')->get();
        return view('view.advice.all', compact('advices'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
         $this->validate($request,[
            'name' => 'required'
        ]);

        $this->addAdvice($request);
        return back()->with('success','Advice Added Successful');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $advice = Advi::find($id);
        return view('view.advice.edit', compact('advice'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);
        $this->editAdvice($request, $id);
        return redirect()->route('doctor.advice.index')->with('success','Advice Update Successful');
    }

    public function destroy($id)
    {
        //
    }
}
