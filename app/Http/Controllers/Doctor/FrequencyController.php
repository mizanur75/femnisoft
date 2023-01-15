<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Frequency;
use App\Traits\FrequencyTrait;

class FrequencyController extends Controller
{
    use FrequencyTrait;
    public function index()
    {
        $frequencies = Frequency::orderBy('id','DESC')->get();
        return view('view.frequency.all', compact('frequencies'));
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'frequency' => 'required|unique:frequencies,name'
        ]);

        $this->addFrequency($request);

        return back()->with('success','Successfully Added!');
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $frequency = Frequency::find($id);
        return view('view.frequency.edit', compact('frequency'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'frequency' => 'required|unique:frequencies,name,'.$id
        ]);

        $this->editFrequency($request, $id);

        return redirect()->route('doctor.frequency.index')->with('success','Successfully Updated!');
    }

    
    public function destroy($id)
    {
        $frequency = Frequency::find($id);
        $frequency->delete();
        return back()->with('success','Successfully Deleted!');
    }
}
