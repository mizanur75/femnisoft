<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Model\Dosage;
use App\Model\Generic;
use App\Model\History;
use App\Model\PatientInfo;
use App\Model\Prescription;
use App\Model\PreTreatment;
use App\Model\Test;
use App\Model\Doctor;
use App\Model\InvoiceMaster;
use App\Model\Type;
use App\Model\Advi;
use App\Model\Medicine;
use App\Model\Report;
use App\Model\Frequency;
use App\Model\Qty;
use App\Model\QtyType;
use App\Model\AppInvoice;
use App\Model\EatingTime;
use App\Model\AdvTran;
use App\Model\Patient;
use App\Model\Finv;
use Auth;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PrescriptionController extends Controller
{

    public function index(Request $request)
    {
        $title = 'My';
        $default_value = 20;
        $input_value = $request->input('search_value');
        if ($input_value) {
            $default_value = $input_value;
        }
        $start = '';
        $finish = '';
        $doctor_id = '';
        $doctors = Doctor::where('status',1)->get();
        $histories = DB::table('histories as hi')
                        ->join('doctors as d','d.id','=','hi.doctor_id')
                        ->join('patient_infos as pi','pi.id','=','hi.patient_info_id')
                        ->join('patients as p','p.id','=','hi.patient_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('hi.id','DESC')
                        ->where('d.user_id',Auth::user()->id)
                        ->select('hi.id as id','hi.visit as visit','hi.diagnosis as diagnosis','hi.test as test','hi.created_at as created_at','hi.age as age','hi.request_id as request_id','hi.suggest_follow_up as suggest_follow_up','u.name as name','d.specialist as spcialist','p.name as patient_name','p.reg_mem as reg_mem','pi.mem_type as mem_type','pi.id as pid','p.age as dob','ad.name as address','p.centre_patient_id as ecohid','d.user_id as did')
                        ->paginate($default_value);
        // if($request->ajax()){
        //     $histories = DB::table('histories as hi')
        //                 ->join('doctors as d','d.id','=','hi.doctor_id')
        //                 ->join('patient_infos as pi','pi.id','=','hi.patient_info_id')
        //                 ->join('patients as p','p.id','=','hi.patient_id')
        //                 ->join('addresses as ad','ad.id','=','p.address_id')
        //                 ->join('users as u','u.id','=','d.user_id')
        //                 ->orderBy('hi.id','DESC')
        //                 ->where('d.user_id',Auth::user()->id)
        //                 ->select('hi.id as id','hi.visit as visit','hi.diagnosis as diagnosis','hi.test as test','hi.created_at as created_at','hi.age as age','hi.request_id as request_id','hi.suggest_follow_up as suggest_follow_up','u.name as name','d.specialist as spcialist','p.name as patient_name','p.reg_mem as reg_mem','pi.mem_type as mem_type','pi.id as pid','p.age as dob','ad.name as address','p.centre_patient_id as ecohid','d.user_id as did')
        //                 ->get();
        //     return DataTables::of($histories)
        //         ->addIndexColumn()
        //         ->editColumn('age', function($histories){
        //             $birth_date = new \DateTime($histories->dob);
        //             $meet_date = new \DateTime($histories->created_at);
        //             $interval = $birth_date->diff($meet_date);
        //             $days = $interval->format('%m M');
        //             $age = $interval->format('%y');
        //             if ($age == 0) {
        //                $age = $days;
        //             }
        //             return $age;
        //         })
        //         ->editColumn('created_at', function($histories){
        //             return date('d M Y', strtotime($histories->created_at));
        //         })
        //         ->editColumn('mem_type', function($histories){
        //             return $histories->mem_type == null ? ($histories->reg_mem == null ? 'OPD' : $histories->reg_mem) : $histories->mem_type;
        //         })
        //         ->editColumn('name', function($histories){
        //             $html = $histories->name;
        //             $html .= '<p style="font-size: 11px;">';
        //             $html .= $histories->spcialist;
        //             $html .= '</p>';
        //             return $html;
        //         })
        //         ->addColumn('reports', function($histories){
        //             if (Report::where('history_id',$histories->id)->count() > 0){
        //                 $button = '<a href="' . route('doctor.reports',$histories->id) . '" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>';
        //             }else{
        //                 if($histories->test == !null){
        //                     $button = '<a href ="'.route('doctor.add_reports',$histories->id).'" target="_blank" class="btn btn-padding btn-sm btn-outline-warning mb-0" ><i class="fa fa-plus" ></i > Add </a >';
        //                 }else{
        //                     $button = '<button class="btn btn-padding btn-sm btn-outline-danger">No Report</button>';
        //                     if ($histories->suggest_follow_up == '0' || (Finv::where('patient_info_id',$histories->pid)->count() > 0)) {
        //                         $button .= '<button onclick="addEdit('.$histories->id.')" class="btn btn-padding btn-sm btn-outline-warning mb-0" ><i class="fa fa-plus" ></i >/<i class="fa fa-edit" ></i > </button>';
        //                     }
        //                 }
        //             }
        //             return $button;
        //         })
        //         ->addColumn('prescription', function($histories){
        //             if (Prescription::where('history_id',$histories->id)->count() > 0) {
        //                 $button = '<a href="' . route('doctor.prescription.show', $histories->id) . '" class="btn btn-padding btn-sm btn-outline-info" target="_blank"><i class="fa fa-eye"></i> See</a>';
        //             }else{
        //                 if(Auth::user()->role->id == 3 && $histories->did == Auth::user()->id) {
        //                     $button = '<a href="'. route('doctor.prescription.edit',$histories->request_id) .'" class="btn btn-padding btn-sm btn-outline-info mb-0" ><i class="fa fa-eye" ></i > Write Prescription </a >';
        //                 }else {
        //                     $button = '<a href = "#" class="btn btn-padding btn-sm btn-outline-warning mb-0" ><i class="fa fa-eye" ></i > Not Ready </a >';
        //                 }
        //             }
        //             return $button;
        //         })
        //         ->rawColumns(['name','reports','prescription'])
        //         ->make(true);
        // }
        return view('view.histories.all_press',compact('title','doctors','default_value','histories','start','finish','doctor_id'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'cc' => 'required',
        ]);

        $visit = History::where('patient_id',$request->patient_id)->count();
        $next_meet = $request->next_meet.' '.$request->meet_day;

        $history = new History();
        $history->request_id = $request->request_id;
        $history->user_id = Auth::user()->id;
        $history->patient_id = $request->patient_id;
        $history->doctor_id = $request->doctor_id;
        $history->cc = $request->cc;
        $history->advice_text = $request->advice_text;
        $history->advices =  $request->advice == !null ? implode(', ', $request->advice):'';
        $history->next_meet = $next_meet;
        $history->referred = $request->referred;
        $history->comment = $request->comment;
        $history->age = $request->age;
        $history->status = 1;
        $history->visit = $visit + 1;
        $history->app_fee = 00;
        $history->absent = $request->absent;
        $history->save();

        DB::table('patient_requests')->where('id',$request->request_id)->update(['done' => 1, 'status' => 1]);

        $message = "You made Prescription";

        return redirect()->route('doctor.patient.show',$request->patient_id)->with('success', $message);
    }

    public function show($id)
    {
        $info = DB::table('histories as h')
                    ->join('doctors as d','d.id','=','h.doctor_id')
                    ->join('chambers as ch','ch.id','=','d.chamber_id')
                    ->join('chambers','chambers.id','=','d.current_work_station')
                    ->join('users as u','u.id','=','d.user_id')
                    ->join('patients as p','p.id','=','h.patient_id')
                    ->join('addresses as ad','ad.id','=','p.address_id')
                    ->join('patient_requests as pare','pare.id','=','h.request_id')
                    // ->join('app_invoices as ai','ai.patient_request_id','=','pare.id')
                    ->where('h.id',$id)
                    ->select('u.name as dname','d.education as education','d.signature as signature','chambers.name as current_work','ch.name as chamber','d.specialist as spc','d.title as title','d.regi_no as regi_no','d.user_id as duser_id','p.id as patientId','p.blood_group as blood_group','p.name as name','p.age as dob','p.gender as gender','p.centre_patient_id as centerid','p.reg_mem as reg_mem','ad.name as address','p.image as image','h.id as hid','h.created_at as meet_date','h.cc as cc','h.next_meet as next_meet','h.advices as advices','h.referred as referred','h.comment as comment','h.age as pres_age','h.visit as visit','h.absent as absent','h.advice_text as advice_text')
                    ->first();

        return view('doctor.prescription.view_prescription',compact('info'));


    }


    public function edit($id)
    {
        $doctors = Doctor::where('status',1)->get();
        $tests = Test::where('status',1)->orderBy('test_name')->get();
        $frequecies = Frequency::all();
        $eating_times = EatingTime::all();
        $qtys = Qty::all();
        $qty_types = QtyType::all();
        $advices = Advi::where('status',1)->get();
        $history_id = DB::table('histories')->where('request_id',$id)->where('status',0)->first();

        if(empty($history_id)){
            $appoint = DB::table('patient_requests as pare')
                            ->join('patients as p','p.id','=','pare.patient_id')
                            ->join('addresses as ad','ad.id','=','p.address_id')
                            ->join('doctors as d','d.id','=','pare.doctor_id')
                            ->join('chambers as ch','ch.id','=','d.chamber_id')
                            ->join('chambers','chambers.id','=','d.current_work_station')
                            ->join('users as u','u.id','=','d.user_id')
                            ->where('d.user_id', Auth::user()->id)
                            ->where('pare.id', $id)
                            ->select('pare.id as pare_id','p.*','d.id as did','d.signature as signature','u.name as dname','d.title as title','d.specialist as specialist','d.education as education','chambers.name as current_work','ch.name as chamber','d.regi_no as regi_no','p.injury as test','p.pulse as cc','ad.name as address')
                            ->first();
            $info = PatientInfo::orderBy('id','DESC')->where('patient_id',$appoint->id)->first();
            return view('doctor.prescription.create_prescription',compact('appoint','info','tests','advices','frequecies','eating_times','qtys','qty_types','doctors'));
        }else{
            $appoint = DB::table('patient_requests as pare')
                        ->join('patients as p','p.id','=','pare.patient_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('chambers as ch','ch.id','=','d.chamber_id')
                        ->join('chambers','chambers.id','=','d.current_work_station')
                        ->join('users as u','u.id','=','d.user_id')
                        ->join('histories as h','h.request_id','=','pare.id')
                        ->where('d.user_id', Auth::user()->id)
                        ->where('pare.id', $id)
                        ->select('pare.id as pare_id','p.*','d.id as did','d.signature as signature','u.name as dname','d.title as title','d.specialist as specialist','d.education as education','chambers.name as current_work','ch.name as chamber','d.regi_no as regi_no','h.id as history_id','h.test as test','h.cc as cc','ad.name as address')
                        ->first();

            // $suggested_test = History::where('id',$appoint->history_id)->get();
            $given_test = History::where('id',$appoint->history_id)->first();
            $info = PatientInfo::orderBy('id','DESC')->where('patient_id',$appoint->id)->first();
            return view('doctor.prescription.create_prescription',compact('appoint','info','tests','given_test','advices','frequecies','eating_times','qtys','qty_types','doctors'));
        }
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cc' => 'required',
        ]);

        $history = History::find($id);

        $next_meet = $request->next_meet.' '.$request->meet_day;
        DB::table('prescriptions')->where('history_id',$id)->delete();

        $history->request_id = $request->request_id;
        $history->user_id = Auth::user()->id;
        $history->patient_id = $request->patient_id;
        $history->doctor_id = $request->doctor_id;
        $history->cc = $request->cc;
        $history->advice_text = $request->advice_text;
        $history->advices =  $request->advice == !null ? implode(', ', $request->advice):'';
        $history->next_meet = $next_meet;
        $history->referred = $request->referred;
        $history->comment = $request->comment;
        $history->age = $request->age;
        $history->status = 1;
        $history->app_fee = 00;
        $history->absent = $request->absent;
        $history->save();

        DB::table('patient_requests')->where('id',$request->request_id)->update(['done' => 1,'status' => 1]);
        $message = "Prescription Updated!";

        return redirect()->route('doctor.prescription.show',$id)->with('success', $message);
    }


    public function destroy($id)
    {
        //
    }
    public function edit_prescription($id){
        $doctors = Doctor::where('status',1)->get();
        $advices = Advi::where('status',1)->get();

        $appoint = DB::table('patient_requests as pare')
                    ->join('patients as p','p.id','=','pare.patient_id')
                    ->join('addresses as ad','ad.id','=','p.address_id')
                    ->join('doctors as d','d.id','=','pare.doctor_id')
                    ->join('chambers as ch','ch.id','=','d.chamber_id')
                    ->join('chambers','chambers.id','=','d.current_work_station')
                    ->join('users as u','u.id','=','d.user_id')
                    ->join('histories as h','h.request_id','=','pare.id')
                    ->where('d.user_id', Auth::user()->id)
                    ->where('h.id', $id)
                    ->select('pare.id as pare_id','p.*','d.id as did','d.signature as signature','u.name as dname','d.title as title','d.specialist as specialist','d.education as education','chambers.name as current_work','ch.name as chamber','d.regi_no as regi_no','h.id as history_id','h.cc as cc','ad.name as address')
                    ->first();
        $info = DB::table('histories as h')
                    ->join('doctors as d','d.id','=','h.doctor_id')
                    ->join('chambers as ch','ch.id','=','d.chamber_id')
                    ->join('chambers','chambers.id','=','d.current_work_station')
                    ->join('users as u','u.id','=','d.user_id')
                    ->join('patients as p','p.id','=','h.patient_id')
                    ->join('addresses as ad','ad.id','=','p.address_id')
                    ->where('h.id',$id)
                    ->select('u.name as dname','d.education as education','d.signature as signature','chambers.name as current_work','ch.name as chamber','d.specialist as spc','d.title as title','d.regi_no as regi_no','p.name as name','p.blood_group as blood_group','p.age as age','p.gender as gender','p.centre_patient_id as centerid','ad.name as address','p.image as image','p.reg_mem as reg_mem','h.id as hid','h.created_at as meet_date','h.cc as cc','h.heart as heart','h.lungs as lungs','h.investigation as investigation','h.suggested_test as suggested_test','h.diagnosis as diagnosis','h.sec_diagnosis as sec_diagnosis','h.sec_dx2 as sec_dx2','h.next_meet as next_meet','h.test as test','h.advices as advices','h.referred as referred','h.referred_by as referred_by','h.follow_up as follow_up','h.comment as comment','h.advice_text as advice_text')
                    ->first();
        return view('doctor.prescription.edit_prescription',compact('appoint','info','advices'));
    }

    public function today($today)
    {
        $title = 'Today\'s';
        $start = null;
        $finish = null;
        $doctor_id = null;
        $default_value = 20;
        $doctors = Doctor::where('status',1)->get();
        $histories = DB::table('histories as hi')
                        ->join('doctors as d','d.id','=','hi.doctor_id')
                        ->join('patients as p','p.id','=','hi.patient_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('hi.id','DESC')
                        ->where('hi.created_at', 'LIKE','%'. $today .'%')
                        ->select('hi.id as id','hi.visit as visit','hi.diagnosis as diagnosis','hi.test as test','hi.created_at as created_at','hi.request_id as request_id','hi.suggest_follow_up as suggest_follow_up','hi.age as age','u.name as name','d.specialist as spcialist','p.name as patient_name','p.reg_mem as reg_mem','p.age as dob','ad.name as address','p.centre_patient_id as ecohid','d.user_id as did')
                        ->paginate($default_value);
        return view('view.histories.all_press',compact('histories','title','doctors','start','finish','doctor_id','default_value'));
    }

    public function select(Request $request){
        if($request->ajax()){
            $qItem=DB::table('medicines')->where('type_id', $request->catID)->where('generic_id', $request->genericID)->pluck('name', 'id')->all();
            $data = view('doctor.ajax',compact('qItem'))->render();
            return response()->json(['options'=>$data]);
        }
    }
    public function live_search(Request $request){
        if($request->ajax()){
            $output = "";
            $qItem=DB::table('prices as pr')
                        ->join('medicines as med','med.id','=','pr.medicine_id')
                        ->join('measurements as mes','mes.id','=','pr.measurement_id')
                        ->where('pr.id',$request->medID)
                        ->select('pr.*','med.name as medname','mes.measurement as mesname')
                        ->get();
            if ($qItem) {
                foreach ($qItem as $sItem) {
                    $output .= '<option value></option>';
                }
            }
        }
    }
    public function onload_medicine(Request $request){

        $medicines = DB::table('prices as pr')
                        ->join('medicines as med','med.id','=','pr.medicine_id')
                        ->join('generics as gn','gn.id','=','med.generic_id')
                        ->join('types as tp','tp.id','pr.type_id')
                        ->join('measurements as mes','mes.id','=','pr.measurement_id')
                        ->where('pr.status',0)
                        ->select('pr.id as id','med.name as medname','tp.name as category','mes.measurement as mesname','gn.name as gname')
                        ->get();
        return response()->json($medicines);
    }
    public function meddetails(Request $request){
        $medicine = DB::table('prices as pr')
                        ->join('medicines as med','med.id','=','pr.medicine_id')
                        ->join('measurements as mes','mes.id','=','pr.measurement_id')
                        ->where('pr.id',$request->medID)
                        ->select('pr.*','med.name as medname','mes.measurement as mesname')
                        ->first();
        return response(['medicine'=>$medicine]);
    }
    public function pre_meddetails(Request $request){
        $pre_dosage = PreTreatment::where('id',$request->pre_treatment_id)->first();
        $medicine = DB::table('prescriptions as pres')
                        ->join('prices as pr','pr.id','=','pres.price_id')
                        ->join('medicines as med','med.id','=','pr.medicine_id')
                        ->join('measurements as mes','mes.id','=','pr.measurement_id')
                        ->where('pr.id',$pre_dosage->price_id)
                        ->select('pr.id','med.name as medname','mes.measurement as mesname')
                        ->first();
        return response(['medicine'=>$medicine,'dosage' => $pre_dosage]);
    }

    public function search_prescription(Request $request){
        $title = 'Search';
        $start = '';
        $finish = '';
        $doctor_id = '';
        $default_value = 20;
        $search_value = $request->input('search_prescription');
        $doctors = Doctor::where('status',1)->get();
        $histories = DB::table('histories as hi')
            ->join('doctors as d','d.id','=','hi.doctor_id')
            ->join('patients as p','p.id','=','hi.patient_id')
            ->join('addresses as ad','ad.id','=','p.address_id')
            ->join('users as u','u.id','=','d.user_id')
            ->where(function ($query) use ($search_value){
                $query->where('p.name','LIKE','%'.$search_value.'%')
                ->orWhere('p.phone','LIKE','%'.$search_value.'%')
                ->orWhere('p.centre_patient_id','LIKE','%'.$search_value.'%');
            })
            ->orderBy('hi.id','DESC')
            ->select('hi.id as id','hi.visit as visit','hi.diagnosis as diagnosis','hi.test as test','hi.created_at as created_at','hi.request_id as request_id','hi.suggest_follow_up as suggest_follow_up','hi.age as age','u.name as name','d.specialist as spcialist','p.name as patient_name','p.reg_mem as reg_mem','p.age as dob','ad.name as address','p.centre_patient_id as ecohid','d.user_id as did')
            ->paginate($default_value);
        return view('view.histories.all_press',compact('title','doctors','default_value','histories','start','finish','doctor_id'));
    }

    public function allprescription(Request $request){
        $title = 'All';
        $default_value = 20;
        $input_value = $request->input('search_value');
        if ($input_value) {
            $default_value = $input_value;
        }
        $start = '';
        $finish = '';
        $doctor_id = '';
        $doctors = Doctor::where('status',1)->get();
        $histories = DB::table('histories as hi')
                        ->join('doctors as d','d.id','=','hi.doctor_id')
                        ->join('patients as p','p.id','=','hi.patient_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('hi.id','DESC')
                        ->select('hi.id as id','hi.visit as visit','hi.diagnosis as diagnosis','hi.test as test','hi.created_at as created_at','hi.request_id as request_id','hi.suggest_follow_up as suggest_follow_up','hi.age as age','u.name as name','d.specialist as spcialist','p.name as patient_name','p.reg_mem as reg_mem','p.age as dob','ad.name as address','p.centre_patient_id as ecohid','d.user_id as did')
                        ->paginate($default_value);
        // if($request->ajax()){
        //     $histories = DB::table('histories as hi')
        //                 ->join('doctors as d','d.id','=','hi.doctor_id')
        //                 ->join('patient_infos as pi','pi.id','=','hi.patient_info_id')
        //                 ->join('patients as p','p.id','=','hi.patient_id')
        //                 ->join('addresses as ad','ad.id','=','p.address_id')
        //                 ->join('users as u','u.id','=','d.user_id')
        //                 ->orderBy('hi.id','DESC')
        //                 ->select('hi.id as id','hi.visit as visit','hi.diagnosis as diagnosis','hi.test as test','hi.created_at as created_at','hi.request_id as request_id','hi.suggest_follow_up as suggest_follow_up','hi.age as age','u.name as name','d.specialist as spcialist','p.name as patient_name','p.reg_mem as reg_mem','pi.mem_type as mem_type','pi.id as pid','p.age as dob','ad.name as address','p.centre_patient_id as ecohid','d.user_id as did')
        //                 ->get();
        //     return DataTables::of($histories)
        //         ->addIndexColumn()
        //         ->editColumn('age', function($histories){
        //             $birth_date = new \DateTime($histories->dob);
        //             $meet_date = new \DateTime($histories->created_at);
        //             $interval = $birth_date->diff($meet_date);
        //             $days = $interval->format('%mM %dD');
        //             $age = $interval->format('%y');
        //             if ($age == 0) {
        //                $age = $days;
        //             }
        //             return $age;
        //         })
        //         ->editColumn('created_at', function($histories){
        //             return date('d M Y', strtotime($histories->created_at));
        //         })
        //         ->editColumn('mem_type', function($histories){
        //             return $histories->mem_type == null ? ($histories->reg_mem == null ? 'OPD' : $histories->reg_mem) : $histories->mem_type;
        //         })
        //         ->editColumn('name', function($histories){
        //             $html = $histories->name;
        //             $html .= '<p style="font-size: 11px;">';
        //             $html .= $histories->spcialist;
        //             $html .= '</p>';
        //             return $html;
        //         })
        //         ->addColumn('reports', function($histories){
        //             if (Report::where('history_id',$histories->id)->count() > 0){
        //                 $button = '<a href="' . route('doctor.reports',$histories->id) . '" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>';
        //             }else{
        //                 if($histories->test == !null){
        //                     $button = '<a href ="'.route('doctor.add_reports',$histories->id).'" target="_blank" class="btn btn-padding btn-sm btn-outline-warning mb-0" ><i class="fa fa-plus" ></i > Add </a >';
        //                 }else{
        //                     $button = '<button class="btn btn-padding btn-sm btn-outline-danger">No Report</button>';
        //                     if ($histories->suggest_follow_up == '0' || (Finv::where('patient_info_id',$histories->pid)->count() > 0)) {
        //                         $button .= '<button onclick="addEdit('.$histories->id.')" class="btn btn-padding btn-sm btn-outline-warning mb-0" ><i class="fa fa-plus" ></i >/<i class="fa fa-edit" ></i > </button>';
        //                     }
        //                 }
        //             }
                    
        //             return $button;
        //         })
        //         ->addColumn('prescription', function($histories){
        //             if (Prescription::where('history_id',$histories->id)->count() > 0) {
        //                 $button = '<a href="' . route('doctor.prescription.show', $histories->id) . '" class="btn btn-padding btn-sm btn-outline-info" target="_blank"><i class="fa fa-eye"></i> See</a>';
        //             }else{
        //                 if(Auth::user()->role->id == 3 && $histories->did == Auth::user()->id) {
        //                     $button = '<a href="'. route('doctor.prescription.edit',$histories->request_id) .'" class="btn btn-padding btn-sm btn-outline-info mb-0" ><i class="fa fa-eye" ></i > Write Prescription </a >';
        //                 }else {
        //                     $button = '<a href ="#" class="btn btn-padding btn-sm btn-outline-warning mb-0" ><i class="fa fa-eye" ></i > Not Ready </a >';
        //                 }
        //             }
        //             return $button;
        //         })
        //         ->rawColumns(['name','reports','prescription'])
        //         ->make(true);
        // }
        return view('view.histories.all_press',compact('title','doctors','default_value','histories','start','finish','doctor_id'));
    }

    public function pres_show_by_dr_date(Request $request){
        $title = 'By Date and Doctor';
        $start = '';
        $finish = '';
        $default_value = 20;
        $doctors = Doctor::where('status',1)->get();
        $doctor_id = $request->doctor_id;

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

        if ($start == null && $finish == null && $doctor_id == !null) {
            $histories = DB::table('histories as hi')
                        ->join('doctors as d','d.id','=','hi.doctor_id')
                        ->join('patients as p','p.id','=','hi.patient_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('hi.id','DESC')
                        ->where('hi.doctor_id',$doctor_id)
                        ->select('hi.id as id','hi.visit as visit','hi.diagnosis as diagnosis','hi.test as test','hi.created_at as created_at','hi.request_id as request_id','hi.suggest_follow_up as suggest_follow_up','hi.age as age','u.name as name','d.specialist as spcialist','p.name as patient_name','p.reg_mem as reg_mem','p.age as dob','ad.name as address','p.centre_patient_id as ecohid','d.user_id as did')
                        ->paginate($default_value);
        }elseif ($start && $finish && $doctor_id == null){
            $histories = DB::table('histories as hi')
                ->join('doctors as d','d.id','=','hi.doctor_id')
                ->join('patients as p','p.id','=','hi.patient_id')
                ->join('addresses as ad','ad.id','=','p.address_id')
                ->join('users as u','u.id','=','d.user_id')
                ->orderBy('hi.id','DESC')
                 ->whereBetween('hi.created_at', [$start, $finish])
                ->select('hi.id as id','hi.visit as visit','hi.diagnosis as diagnosis','hi.test as test','hi.created_at as created_at','hi.request_id as request_id','hi.suggest_follow_up as suggest_follow_up','hi.age as age','u.name as name','d.specialist as spcialist','p.name as patient_name','p.reg_mem as reg_mem','p.age as dob','ad.name as address','p.centre_patient_id as ecohid','d.user_id as did')
                ->paginate($default_value);
        }elseif ($start == null && $finish == null && $doctor_id == null) {
            $histories = DB::table('histories as hi')
                        ->join('doctors as d','d.id','=','hi.doctor_id')
                        ->join('patients as p','p.id','=','hi.patient_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('hi.id','DESC')
                        ->select('hi.id as id','hi.visit as visit','hi.diagnosis as diagnosis','hi.test as test','hi.created_at as created_at','hi.request_id as request_id','hi.suggest_follow_up as suggest_follow_up','hi.age as age','u.name as name','d.specialist as spcialist','p.name as patient_name','p.reg_mem as reg_mem','p.age as dob','ad.name as address','p.centre_patient_id as ecohid','d.user_id as did')
                        ->paginate($default_value);
        }else{

            $histories = DB::table('histories as hi')
                            ->join('doctors as d','d.id','=','hi.doctor_id')
                            ->join('patients as p','p.id','=','hi.patient_id')
                            ->join('addresses as ad','ad.id','=','p.address_id')
                            ->join('users as u','u.id','=','d.user_id')
                            ->orderBy('hi.id','DESC')
                            ->whereBetween('hi.created_at', [$start, $finish])
                            ->where('hi.doctor_id',$doctor_id)
                            ->select('hi.id as id','hi.visit as visit','hi.diagnosis as diagnosis','hi.test as test','hi.created_at as created_at','hi.request_id as request_id','hi.suggest_follow_up as suggest_follow_up','hi.age as age','u.name as name','d.specialist as spcialist','p.name as patient_name','p.reg_mem as reg_mem','p.age as dob','ad.name as address','p.centre_patient_id as ecohid','d.user_id as did')
                            ->paginate($default_value);
        }
        return view('view.histories.all_press',compact('histories','title','doctors','doctor_id','start','finish','default_value'));
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

    public function storeReport(Request $request){
        
        $message = "Investigation Advised!";
        return redirect()->route('doctor.appoint_today',\Carbon\Carbon::parse()->format('d-m-Y'))->with('success', $message);
    }
}
