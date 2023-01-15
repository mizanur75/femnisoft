<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Chamber;
use Auth;

class ChamberController extends Controller
{

    public function index()
    {
        $chambers = Chamber::orderBy('id','DESC')->get();
        return view('admin.chamber.all', compact('chambers'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
        ]);

        $image = $request->file('logo');
        $slug = str_slug($request->name);

        if (isset($image)) {
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!file_exists('images/chamber')) {
                mkdir('images/chamber', 755, true);
            }
            $image->move('images/chamber', $imagename);
        }else{
            $imagename = '';
        }

        $chamber = new Chamber();
        $chamber->user_id = Auth::user()->id;
        $chamber->name = $request->name;
        $chamber->address = $request->address;
        $chamber->post_code = $request->post_code;
        $chamber->logo = $imagename;
        $chamber->status = $request->status == null ? 0 : $request->status;
        $chamber->save();

        return back()->with('success','Chamber Added Successful!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $chamber = Chamber::find($id);
        return view('admin.chamber.edit', compact('chamber'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
        ]);

        $image = $request->file('logo');
        $slug = str_slug($request->name);
        $chamber = Chamber::find($id);

        if (isset($image)) {
            if (file_exists('images/chamber/'.$chamber->logo)) {
                unlink('images/chamber/'.$chamber->logo);
            }
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!file_exists('images/chamber')) {
                mkdir('images/chamber', 755, true);
            }
            $image->move('images/chamber', $imagename);
        }else{
            $imagename = $chamber->logo;
        }
        $chamber->user_id = Auth::user()->id;
        $chamber->name = $request->name;
        $chamber->address = $request->address;
        $chamber->post_code = $request->post_code;
        $chamber->logo = $imagename;
        $chamber->status = $request->status == null ? $chamber->status : $request->status;
        $chamber->save();

        return redirect()->route('admin.chamber.index')->with('success','Chamber Updated Successful!');
    }

    public function destroy($id)
    {
        //
    }
}
