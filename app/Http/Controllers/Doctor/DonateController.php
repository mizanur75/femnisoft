<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Donate;
use App\Traits\DonateTrait;
use Auth;

class DonateController extends Controller
{
    use DonateTrait;
    public function index()
    {
        $donates = $this->allDonate();
        $start = '';
        $finish = '';
        return view('view.donate.all', compact('donates','start','finish'));
    }
    public function create()
    {
        $donates = $this->allDonate();
        $start = '';
        $finish = '';
        return view('view.donate.all', compact('donates','start','finish'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'amount' => 'required'
        ]);
        $this->addDonate($request);
        return back()->with('success','Added');
    }

    public function show($id)
    {
        $invoice = $this->invoice($id);
        return view('view.donate.invoice', compact('invoice'));

    }

    public function edit($id)
    {
        $donate = Donate::find($id);
        return response($donate);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'amount' => 'required'
        ]);
        $this->editDonate($request, $id);
        return back()->with('success','Updated');
    }

    public function destroy($id)
    {
        //
    }

    public function donation_search(Request $request){

        $payment_from = $request->payment_from;

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

        if ($payment_from == null) {
            $donates = Donate::orderBy('id','DESC')
                        ->whereBetween('donate_date', [$start, $finish])
                        ->get();
            return view('view.donate.all', compact('donates','start','finish','payment_from'));
        }
        if ($start == null && $finish == null) {
            $donates = Donate::orderBy('id','DESC')
                        ->where('payment_from',$payment_from)
                        ->get();
            return view('view.donate.all', compact('donates','start','finish','payment_from'));
        }
        if ($start == !null && $finish == !null && $payment_from == !null) {
            $donates = Donate::orderBy('id','DESC')
                        ->where('payment_from',$payment_from)
                        ->whereBetween('donate_date', [$start, $finish])
                        ->get();
            return view('view.donate.all', compact('donates','start','finish','payment_from'));
        }

        $donates = Donate::orderBy('id','DESC')
                    ->whereBetween('donate_date', [$start, $finish])
                    ->get();
        return view('view.donate.all', compact('donates','start','finish','payment_from'));
    }
}
