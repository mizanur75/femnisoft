<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\EatingtimeTrait;
use App\Model\EatingTime;


class EatingtimeController extends Controller
{
    use EatingtimeTrait;
    public function index()
    {
        $eatingtimes = EatingTime::orderBy('id','DESC')->get();
        return view('view.eatingtime.all', compact('eatingtimes'));
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'eating_time' => 'required|unique:eating_times,name'
        ]);

        $this->addEatingtime($request);

        return back()->with('success','Successfully Added!');
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $eatingtime = EatingTime::find($id);
        return view('view.eatingtime.edit', compact('eatingtime'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'eating_time' => 'required|unique:eating_times,name,'.$id
        ]);

        $this->editEatingtime($request, $id);

        return redirect()->route('doctor.eatingtime.index')->with('success','Successfully Updated!');
    }

    
    public function destroy($id)
    {
        $eatingtime = EatingTime::find($id);
        $eatingtime->delete();
        return back()->with('success','Successfully Deleted!');
    }
}
