<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Type;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::orderBy('id', 'DESC')->get();
        return view('admin.type.all', compact('types'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $type = new Type();
        $type->name = $request->name;
        $type->slug = str_slug($request->name);
        $type->status = $request->status;
        $type->save();
        return back()->with('success','Successfully added!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $type = Type::find($id);
        return view('admin.type.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $type = Type::find($id);
        $type->name = $request->name;
        $type->slug = str_slug($request->name);
        if($request->status == !null){
            $type->status = $request->status;
        }else{
            $type->status = 0;
        }
        $type->save();
        return redirect()->route('admin.type.index')->with('success','Successfully Updated!');
    }

    public function destroy($id)
    {
        $type = Type::find($id);
        $type->delete();
        return back()->with('success','Successfully Deleted!');
    }
}
