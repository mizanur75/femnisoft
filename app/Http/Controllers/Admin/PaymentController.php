<?php

namespace App\Http\Controllers\Admin;

use App\Model\AppInvoice;
use App\Model\PaidAmount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index(Request $request){
        $total = 0;
        $pay_amount = 0;
        $invoices = AppInvoice::select('amount','pay_amount')->get();
        $paid_amount = PaidAmount::where('status',1)->select('amount')->get();

        foreach ($invoices as $invoice){
            $total += $invoice->amount;
            $pay_amount += $invoice->pay_amount;
        }

        return view('admin.payment.index', compact('pay_amount','paid_amount','total'));
    }

    public function payment_all(){
        $paid_amount = PaidAmount::orderBy('id','DESC')->get();
        return view('admin.payment.payment', compact('paid_amount'));
    }

    public function store_payment(Request $request){

        $this->validate($request ,[
            'amount' => 'required',
        ]);
        $paid_amount = new PaidAmount();
        $paid_amount->user_id = Auth::user()->id;
        $paid_amount->amount = $request->amount;
        $paid_amount->payment_type = $request->payment_type;
        $paid_amount->account_no = $request->account_no;
        $paid_amount->transection_id = $request->transection_id;
        $paid_amount->status = 0;
        $paid_amount->save();

        return back()->with('success','Payment Creation Done, Please confirm');
    }

    public function received_payment($id){
        DB::table('paid_amounts')->where('id',$id)->update(['status' => 1, 'updated_at' => date(now())]);
        return back()->with('success','Payment Received');
    }
}
