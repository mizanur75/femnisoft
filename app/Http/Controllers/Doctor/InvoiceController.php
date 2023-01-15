<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Test;
use App\Model\Report;
use App\Model\Doctor;
use App\Model\History;
use App\Model\Patient;
use App\Model\AppInvoice;
use App\Model\InvoiceMaster;
use App\Model\InvoiceDetails;
use Auth;
use DB;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $doctors = Doctor::orderBy('id','DESC')->where('status',1)->get();
        $title = "All Lab Invoice";
        $invoices = InvoiceMaster::orderBy('id','DESC')->get();
        $total = 0;
        foreach($invoices as $invoice){
            $subtotal = 0;
            foreach($invoice->invoicedetails as $inv){
                $subtotal += $inv->linetotal;
            }
            $total += $subtotal;
        }
        if($request->ajax())
        {
            $invoices = InvoiceMaster::orderBy('id','DESC')->get();

            return DataTables::of($invoices)
                ->addIndexColumn()
                ->addColumn('centre_patient_id', function($invoices){
                    return $invoices->patient->centre_patient_id;
                })
                ->editColumn('patient_id', function($invoices){
                    return $invoices->patient->name;
                })
                ->editColumn('doctor_id', function($invoices){
                    return $invoices->doctor_id == 0 ? 'Self' : $invoices->doctor->user->name;
                })
                ->editColumn('created_at', function($invoices){
                    return date('d M Y', strtotime($invoices->created_at));
                })
                ->addColumn('amount', function($invoices){
                    $subtotal = 0;
                    foreach($invoices->invoicedetails as $inv){
                        $subtotal += $inv->linetotal;
                    }
                    return $subtotal;
                })
                ->addColumn('patient_type', function($invoices){
                    foreach ($invoices->patient->patient_info as $pi) {
                        return $pi->mem_type == null ? 'OPD' : $pi->mem_type;
                    }
                })
                ->addColumn('invoice', function($invoices){
                    $button = '<a href="'. route('doctor.invoice.show', \Crypt::encrypt($invoices->id)) .'" class="btn btn-padding btn-sm btn-info" target="_blank"><i class="fa fa-file-invoice"></i> View</a>';
                    return $button;
                })
                ->rawColumns(['invoice'])
                ->make(true);
        }

        return view('view.invoice.report', compact('invoices','title','total','doctors'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'patient_id' => 'required',
            'doctor_id' => 'required',
            'history_id' => 'required',
        ]);
        if (InvoiceMaster::count() > 0){
            $last_id_temp= InvoiceMaster::all()->last()->id;
        }else{
            $last_id_temp = 0;
        }
        $invoice_no = $last_id_temp+1;

        if ($request->ecoh_id) {
            $patient_id = Patient::where('centre_patient_id',$request->ecoh_id)->select('id')->first();
            $patient_id = $patient_id->id;
        }else{
            $patient_id = $request->patient_id;
        }

        $invoice_master = new InvoiceMaster();
        $invoice_master->patient_id = $patient_id;
        $invoice_master->doctor_id = $request->doctor_id;
        $invoice_master->history_id = $request->history_id;
        $invoice_master->invoice_no = "ECOH-".$invoice_no;
        $invoice_master->status = 0;
        $invoice_master->save();

        $id = DB::getPdo()->lastInsertId();

        foreach ($request->test_id as $key => $value) {
            $invoice_details = new InvoiceDetails();
            $invoice_details->invoice_master_id = $id;
            $invoice_details->test_id = $value;
            $invoice_details->unitcost = $request->unitcost [$key];
            $invoice_details->discount = $request->discount [$key];
            $invoice_details->linetotal = $request->lineTotal [$key];
            $invoice_details->save();
        }

        return redirect()->route('doctor.invoice.show',\Crypt::encrypt($id));
    }

    public function show($iid)
    {
        $id = \Crypt::decrypt($iid);
        $invoice_master = InvoiceMaster::find($id);
        if($invoice_master->history){
            $mem_type = $invoice_master->history->patient_info->mem_type;
        }else{
            $created_at = date('Y-m-d',strtotime($invoice_master->created_at));
            $mem_type = DB::table('histories as hi')
                    ->join('patient_infos as pi','pi.id','=','hi.patient_info_id')
                    ->where('hi.patient_id', $invoice_master->patient_id)
                    // ->where('hi.created_at','LIKE','%'.$created_at.'%')
                    ->select('pi.mem_type as mem_type')
                    ->first();
            if ($mem_type){
                $mem_type = $mem_type->mem_type;
            }else{
                $mem_type = "OPD";
            }
        }

        return view('view.invoice.invoice',compact('invoice_master','mem_type'));
    }

    public function edit($iid)
    {
        $id = \Crypt::decrypt($iid);
        $invoice_master = InvoiceMaster::find($id);
        $tests = Test::orderBy('test_name')->get();
        return view('view.invoice.edit_invoice',compact('tests','invoice_master'));
    }

    public function update(Request $request, $id)
    {
        InvoiceDetails::where('invoice_master_id',$id)->delete();

        foreach ($request->test_id as $key => $value) {
            $invoice_details = new InvoiceDetails();
            $invoice_details->invoice_master_id = $id;
            $invoice_details->test_id = $value;
            $invoice_details->unitcost = $request->unitcost [$key];
            $invoice_details->discount = $request->discount [$key];
            $invoice_details->linetotal = $request->lineTotal [$key];
            $invoice_details->save();
        }

        return redirect()->route('doctor.invoice.show',\Crypt::encrypt($id));
    }

    public function destroy($id)
    {
        //
    }

    public function consultation(Request $request)
    {
        $title = "All Consult. Invoice";
        $doctors = Doctor::where('status',1)->get();

        $total = 0;
        $invoices = AppInvoice::select('amount')->get();
        foreach ($invoices as $invoice){
            $total += $invoice->amount;
        }
        if($request->ajax())
        {
            $invoices = DB::table('app_invoices as ai')
                ->join('patient_requests as pr','pr.id','=','ai.patient_request_id')
                ->join('patient_infos as pi','pi.id','=','pr.patient_info_id')
                ->join('patients as p','p.id','=','ai.patient_id')
                ->join('doctors as d','d.id','=','ai.doctor_id')
                ->join('users as u','u.id','=','d.user_id')
                ->select('pr.appoint_date as appoint_date','p.centre_patient_id as centre_patient_id','pi.mem_type as patient_type','p.name as pname','u.name as dname','ai.amount as amount','ai.id as id','ai.created_at as created_at')
                ->get();

            return DataTables::of($invoices)
                ->addIndexColumn()
                ->editColumn('appoint_date', function($invoices){
                    return date('d M Y', strtotime($invoices->appoint_date));
                })
                ->editColumn('created_at', function($invoices){
                    return date('d M Y', strtotime($invoices->created_at));
                })
                ->addColumn('action', function($invoices){
                    $button = '<a href="'. route('doctor.consultationInvoiceEdit',$invoices->id) .'" class="btn btn-padding btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('view.invoice.all', compact('title','doctors','total'));
    }

    public function consultationInvoiceEdit($id){
        $invoice = AppInvoice::find($id);
        return view('view.invoice.consult_invoice_edit',compact('invoice'));
    }
    public function consultationInvoiceEdited(Request $request, $id){
        $invoice = AppInvoice::find($id);
        $invoice->amount = $request->amount;
        $invoice->save();
        return redirect()->route('doctor.consultation')->with('success','Consultation Fee Edit Successful');
    }

    public function search_lab_invoice_by_dr_date(Request $request){
        $title = "Search Lab. Invoice";
        $doctors = Doctor::where('status',1)->get();

        if ($request->doctor_id == null) {
            $doctor_id = '';
        }else{
            $doctor_id = $request->doctor_id;
        }

        if ($request->start == null) {
            $start = '';
        }else{
            $start = date('Y-m-d', strtotime($request->start));
        }
        if ($request->finish == null) {
            $finish = '';
        }else{
            $finish = date('Y-m-d', strtotime($request->finish));
        }


        if ($doctor_id == null) {
            $invoices = InvoiceMaster::orderBy('id','DESC')
                        ->whereBetween('created_at', [$start." 00:00:00", $finish." 23:59:59"])
                        ->get();
            return view('view.invoice.search_lab_invoice', compact('invoices','title','doctors','start','finish','doctor_id'));
        }
        if ($start == null && $finish == null) {
            $invoices = InvoiceMaster::orderBy('id','DESC')
                        ->where('doctor_id',$doctor_id)
                        ->get();
            return view('view.invoice.search_lab_invoice', compact('invoices','title','doctors','start','finish','doctor_id'));
        }



        $invoices = InvoiceMaster::orderBy('id','DESC')
                        ->where('doctor_id',$doctor_id)
                        ->whereBetween('created_at', [$start." 00:00:00", $finish." 23:59:59"])
                        ->get();
        return view('view.invoice.search_lab_invoice', compact('invoices','title','doctors','start','finish','doctor_id'));
    }

    public function invoice_by_dr_date(Request $request){
        $title = "All Appoint Invoice";
        $doctors = Doctor::where('status',1)->get();

        if ($request->doctor_id == null) {
            $doctor_id = '';
        }else{
            $doctor_id = $request->doctor_id;
        }

        if ($request->start == null) {
            $start = '';
        }else{
            $start = date('Y-m-d', strtotime($request->start));
        }
        if ($request->finish == null) {
            $finish = '';
        }else{
            $finish = date('Y-m-d', strtotime($request->finish));
        }


        if ($doctor_id == null) {
            // $invoices = AppInvoice::orderBy('id','DESC')
            //             ->whereBetween('created_at', [$start." 00:00:00", $finish." 23:59:59"])
            //             ->get();
            $invoices = DB::table('app_invoices as ai')
                ->join('patient_requests as pr','pr.id','=','ai.patient_request_id')
                ->join('patient_infos as pi','pi.id','=','pr.patient_info_id')
                ->join('patients as p','p.id','=','ai.patient_id')
                ->join('doctors as d','d.id','=','ai.doctor_id')
                ->join('users as u','u.id','=','d.user_id')
                ->orderBy('ai.id','DESC')
                ->whereBetween('ai.created_at', [$start." 00:00:00", $finish." 23:59:59"])
                ->select('pr.appoint_date as appoint_date','p.centre_patient_id as centre_patient_id','pi.mem_type as patient_type','p.name as pname','u.name as dname','ai.amount as amount','ai.id as id','ai.created_at as created_at')
                ->get();
            return view('view.invoice.search_invoice', compact('invoices','title','doctors','start','finish','doctor_id'));
        }
        if ($start == null && $finish == null) {
            // $invoices = AppInvoice::orderBy('id','DESC')
            //             ->where('doctor_id',$doctor_id)
            //             ->get();
            $invoices = DB::table('app_invoices as ai')
                ->join('patient_requests as pr','pr.id','=','ai.patient_request_id')
                ->join('patient_infos as pi','pi.id','=','pr.patient_info_id')
                ->join('patients as p','p.id','=','ai.patient_id')
                ->join('doctors as d','d.id','=','ai.doctor_id')
                ->join('users as u','u.id','=','d.user_id')
                ->orderBy('ai.id','DESC')
                ->where('ai.doctor_id', $doctor_id)
                ->select('pr.appoint_date as appoint_date','p.centre_patient_id as centre_patient_id','pi.mem_type as patient_type','p.name as pname','u.name as dname','ai.amount as amount','ai.id as id','ai.created_at as created_at')
                ->get();
            return view('view.invoice.search_invoice', compact('invoices','title','doctors','start','finish','doctor_id'));
        }



        // $invoices = AppInvoice::orderBy('id','DESC')
        //                 ->where('doctor_id',$doctor_id)
        //                 ->whereBetween('created_at', [$start." 00:00:00", $finish." 23:59:59"])
        //                 ->get();
        $invoices = DB::table('app_invoices as ai')
                ->join('patient_requests as pr','pr.id','=','ai.patient_request_id')
                ->join('patient_infos as pi','pi.id','=','pr.patient_info_id')
                ->join('patients as p','p.id','=','ai.patient_id')
                ->join('doctors as d','d.id','=','ai.doctor_id')
                ->join('users as u','u.id','=','d.user_id')
                ->orderBy('ai.id','DESC')
                ->where('ai.doctor_id',$doctor_id)
                ->whereBetween('ai.created_at', [$start." 00:00:00", $finish." 23:59:59"])
                ->select('pr.appoint_date as appoint_date','p.centre_patient_id as centre_patient_id','pi.mem_type as patient_type','p.name as pname','u.name as dname','ai.amount as amount','ai.id as id','ai.created_at as created_at')
                ->get();
        return view('view.invoice.search_invoice', compact('invoices','title','doctors','start','finish','doctor_id'));
    }

    public function invoice_create($id){
        $tests = Test::all();
        $history = History::find($id);
        $patient = Patient::find($history->patient_id);
        $info = DB::table('histories as h')
                    ->join('patients as p','p.id','=','h.patient_id')
                    ->join('addresses as ad','ad.id','=','p.address_id')
                    ->join('doctors as d','d.id','=','h.doctor_id')
                    ->join('chambers as ch','ch.id','=','d.chamber_id')
                    ->join('users as u','u.id','=','d.user_id')
                    ->where('h.id','=',$id)
                    ->select('p.name as name','p.age as age', 'p.gender as gender','ad.name as address' ,'u.name as dname','d.title as title','d.specialist as spcialist','d.current_work_station as work','ch.name as chamber','h.id as id','d.id as did')
                    ->first();
        $reports = explode(', ', $history->test);
        return view('agent.invoice.create_invoice', compact('info','reports','patient','history','tests'));
    }

    public function self_invoice(){
        $tests = Test::all();
        $doctors = Doctor::where('status',1)->get();
        return view('view.invoice.self_invoice', compact('doctors','tests'));
    }

}
