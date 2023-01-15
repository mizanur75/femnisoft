<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Qty;
use App\Traits\QtyTrait;

class QtyController extends Controller
{
    use QtyTrait;
    public function index()
    {
        $qties = Qty::orderBy('id','DESC')->get();
        return view('view.qty.all', compact('qties'));
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'qty' => 'required|unique:qties,name'
        ]);


        $this->addQty($request);
        return back()->with('success','Successfully Added!');
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $qty = Qty::find($id);
        return view('view.qty.edit', compact('qty'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'qty' => 'required|unique:qties,name,'.$id
        ]);

        $this->editQty($request, $id);

        return redirect()->route('doctor.qty.index')->with('success','Successfully Updated!');
    }

    
    public function destroy($id)
    {
        $qty = Qty::find($id);
        $qty->delete();
        return back()->with('success','Successfully Deleted!');
    }
}
