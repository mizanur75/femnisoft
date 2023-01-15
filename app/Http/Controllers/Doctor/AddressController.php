<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Address;
use Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::orderBy('id','DESC')->get();
        return view('view.address.all', compact('addresses'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request ,[
            'name' => 'required'
        ]);

        $address = new Address();
        $address->name = $request->name;
        $address->create_userid = Auth::user()->id;
        $address->update_userid = Auth::user()->id;
        $address->create_userip = $request->ip();
        $address->update_userid = $request->ip();
        $address->save();

        return back()->with('success','Address Added Successful');
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $address = Address::find($id);
        return view('view.address.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request ,[
            'name' => 'required'
        ]);

        $address = Address::find($id);
        $address->name = $request->name;
        $address->update_userid = Auth::user()->id;
        $address->update_userid = $request->ip();
        $address->save();

        return redirect()->route('doctor.address.index')->with('success','Address Updated Successful');
    }

    public function destroy($id)
    {
        //
    }
}