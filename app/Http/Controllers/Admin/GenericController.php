<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Generic;

class GenericController extends Controller
{
    public function index()
    {
        $generics = Generic::orderBy('id', 'DESC')->get();
        return view('admin.generic.all', compact('generics'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $generic = new Generic();
        $generic->name = $request->name;
        $generic->slug = str_slug($request->name);
        $generic->description = $request->description;
        $generic->indication = $request->indication;
        $generic->status = $request->status;
        $generic->save();
        return back()->with('success','Successfully added!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $generic = Generic::find($id);
        return view('admin.generic.edit', compact('generic'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $generic = Generic::find($id);
        $generic->name = $request->name;
        $generic->slug = str_slug($request->name);
        $generic->description = $request->description;
        $generic->indication = $request->indication;
        if($request->status == !null){
            $generic->status = $request->status;
        }else{
            $generic->status = 0;
        }
        $generic->save();
        return redirect()->route('admin.generic.index')->with('success','Successfully Updated!');
    }

    public function destroy($id)
    {
        $generic = Generic::find($id);
        $generic->delete();
        return back()->with('success','Successfully Deleted!');
    }
}
