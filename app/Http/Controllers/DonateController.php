<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Donate;
use Auth;

class DonateController extends Controller
{
    public function index()
    {
        $donates = Donate::orderBy('id','DESC')->get();
        return view('view.donate.all', compact('donates'));
    }
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $donate = new Donate();
        $donate->name = $request->name;
        $donate->address = $request->address;
        $donate->create_userid = Auth::user()->id;
        $donate->update_userid = Auth::user()->id;
        $donate->create_userip = $request->ip();
        $donate->update_userip = $request->ip();
        $donate->save();
        return back()->with('success','Donation Added');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $donate = Donate::find($id);
        return view('view.donate');
    }

    public function update(Request $request, $id)
    {
        $donate = Donate::find($id);
        $donate->name = $request->name;
        $donate->address = $request->address;
        $donate->create_userid = Auth::user()->id;
        $donate->update_userid = Auth::user()->id;
        $donate->create_userip = $request->ip();
        $donate->update_userip = $request->ip();
        $donate->save();
        return redirect()->route('donate.index')->with('success','Donation Added');
    }

    public function destroy($id)
    {
        //
    }
}
