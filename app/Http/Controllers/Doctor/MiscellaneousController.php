<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Miscellaneous;
use App\Traits\MiscellaneousTrait;
use Auth;

class MiscellaneousController extends Controller
{
    use MiscellaneousTrait;
    public function index()
    {
        $miscellaneouses = $this->allMiscellaneous();
        $start = '';
        $finish = '';
        return view('view.miscellaneous.all', compact('miscellaneouses','start','finish'));
    }
    public function create()
    {
        $miscellaneouses = $this->allMiscellaneous();
        $start = '';
        $finish = '';
        return view('view.miscellaneous.all', compact('miscellaneouses','start','finish'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'address' => 'required',
            // 'phone' => 'required',
            'amount' => 'required'
        ]);
        $this->addMiscellaneous($request);
        return back()->with('success','Added');
    }

    public function show($id)
    {
        $invoice = $this->invoice($id);
        return view('view.miscellaneous.invoice', compact('invoice'));

    }

    public function edit($id)
    {
        $Miscellaneous = Miscellaneous::find($id);
        return response($Miscellaneous);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'address' => 'required',
            // 'phone' => 'required',
            'amount' => 'required'
        ]);
        $this->editMiscellaneous($request, $id);
        return back()->with('success','Updated');
    }

    public function destroy($id)
    {
        //
    }

    public function miscellaneouses_search(Request $request){

        if ($request->start == null) {
            $start = '';
        }else{
            $start = date('Y-m-d', strtotime($request->start))." 00:00:00";
        }
        if ($request->finish == null) {
            $finish = '';
        }else{
            $finish = date('Y-m-d', strtotime($request->finish))." 23:59:59";
        }

        $miscellaneouses = Miscellaneous::orderBy('id','DESC')
                    ->whereBetween('Miscellaneous_date', [$start, $finish])
                    ->get();
        return view('view.miscellaneous.all', compact('miscellaneouses','start','finish'));

    }
}
