<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\QtyType;
use App\Traits\QtyTypeTrait;

class QtytypeController extends Controller
{
    use QtyTypeTrait;
    public function index()
    {
        $qty_types = QtyType::orderBy('id','DESC')->get();
        return view('view.qtytype.all', compact('qty_types'));
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'qty_type' => 'required|unique:qty_types,name'
        ]);

        $this->addQtyType($request);

        return back()->with('success','Successfully Added!');
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $qtytype = QtyType::find($id);
        return view('view.qtytype.edit', compact('qtytype'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'qty_type' => 'required|unique:qty_types,name,'.$id
        ]);

        $this->editQtyType($request, $id);

        return redirect()->route('doctor.qtytype.index')->with('success','Successfully Updated!');
    }

    
    public function destroy($id)
    {
        $qtytype = QtyType::find($id);
        $qtytype->delete();
        return back()->with('success','Successfully Deleted!');
    }
}
