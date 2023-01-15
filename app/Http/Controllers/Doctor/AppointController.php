<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Model\History;
use App\Model\PatientInfo;
use App\Model\PatientRequest;
use App\Model\Patient;
use App\Model\Report;
use App\Model\Test;
use App\Model\Doctor;
use App\Model\ApptTime;
use App\User;
use App\Events\CallingEvent;
use Auth;
use DB;
use Illuminate\Http\Request;

class AppointController extends Controller
{

    public function index()
    {
        $title = 'All';
        $appoints = DB::table('patient_requests as pare')
                        ->join('patients as p','p.id','=','pare.patient_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('pare.status',0)
                        ->where('pare.is_delete',0)
                        ->select('pare.*','p.id as pid','p.centre_patient_id as ecohid','p.name as name','p.age as age','ad.name as address','p.blood_group as blood_group','d.id as did','u.name as dname','d.user_id as doctor_user_id')
                        ->get();
        return view('doctor.appoint.all_appoint', compact('appoints','title'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        DB::table('patient_requests')->where('id',$id)->update(['accept'=>1]);
        $appoint = DB::table('patient_requests as pare')
                        ->join('patients as p','p.id','=','pare.patient_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('d.user_id', Auth::user()->id)
                        ->where('pare.id', $id)
                        ->select('pare.id as pare_id','pare.user_id as agent_id','p.*','ad.name as address','d.id as did','u.name as dname')
                        ->first();

        $patient = Patient::where('centre_patient_id',$appoint->centre_patient_id)->first();

        $appoints = DB::table('patient_requests as pare')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('pare.patient_id', $patient->id)
                        ->orderBy('pare.id','DESC')
                        ->select('pare.*','d.id as did','u.name as dname')
                        ->get();
        $tests = Test::all();
        $calling = User::where('id',$appoint->agent_id)->first();

        $histories = DB::table('histories as hi')
                        ->join('doctors as d','d.id','=','hi.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('id','DESC')
                        ->where('hi.patient_id',$appoint->id)
                        ->select('hi.*','u.name as name','d.specialist as spcialist')
                        ->get();
        $patientinfos = PatientInfo::orderBy('id','DESC')->where('patient_id',$appoint->id)->get();

        return view('doctor.appoint.details', compact('appoint','appoints','histories','patientinfos','calling','patient','tests'));
    }

    public function edit($id)
    {
        $info = DB::table('histories as h')
                    ->join('doctors as d','d.id','=','h.doctor_id')
                    ->join('chambers as ch','ch.id','=','d.chamber_id')
                    ->join('users as u','u.id','=','d.user_id')
                    ->join('patients as p','p.id','=','h.patient_id')
                    ->join('patient_infos as pi','pi.id','=','h.info_id')
                    ->where('h.id',$id)
                    ->select('u.name as dname','d.education as education','d.signature as signature','d.current_work_station as work','ch.name as chamber','d.specialist as spc','d.title as title','d.regi_no as regi_no','p.name as name','p.age as age','p.gender as gender','p.centre_patient_id as centerid','h.id as hid','h.created_at as meet_date','h.cc as cc','h.investigation as investigation','h.suggested_test as suggested_test','h.diagnosis as diagnosis','h.next_meet as next_meet','h.test as test','h.advices as advices','pi.blood_presure as bp','pi.temp as temp','pi.pulse as pulse','pi.weight as weight','pi.height as height','pi.oxygen as oxygen','pi.predochos as predochos','pi.preinvestigation as preinvestigation','pi.pretreatment as pretreatment')
                    ->first();
        $prescriptions = DB::table('prescriptions as pre')
                            ->join('histories as h','h.id','=','pre.history_id')
                            ->join('prices as pr','pr.id','=','pre.price_id')
                            ->join('types as tp','tp.id','=','pr.type_id')
                            ->join('medicines as med','med.id','=','pr.medicine_id')
                            ->join('generics as gn','gn.id','=','med.generic_id')
                            ->where('pre.history_id', $id)
                            ->select('pre.*','med.name as medname','tp.name as cat')
                            ->orderBy('pre.id','DESC')
                            ->get();
        return view('doctor.prescription.view_prescription',compact('prescriptions','info'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $appoint = PatientRequest::find($id);
        $appoint->delete();
        toastr('A request has been deleted!','error');
        return back();
    }

    public function get_appoint(){
        $online_appoints = ApptTime::where('status', 0)->where('is_declined', 0)->orderBy('id','DESC')->get();
        return view('doctor.appoint.online_appoint', compact('online_appoints'));
    }

    public function accept($id){
        ApptTime::where('id', $id)->update(['is_accept'=>1]);
        toastr('Appoint Accepted!','success');
        return back();
    }

    public function declined($id){
        ApptTime::where('id', $id)->update(['is_declined'=>1]);
        toastr('Appoint Declined!','error');
        return back();
    }

    public function deleteappoint($id)
    {
        PatientRequest::where('id',$id)->update(['accept' => 0,'done' => 0,'status' => 0,'is_delete'=>1]);
        toastr('A request has been deleted!','error');
        return back();
    }

    public function reports($id){
        $info = DB::table('histories as h')
                    ->join('patients as p','p.id','=','h.patient_id')
                    ->join('addresses as ad','ad.id','=','p.address_id')
                    ->join('doctors as d','d.id','=','h.doctor_id')
                    ->join('chambers as ch','ch.id','=','d.chamber_id')
                    ->join('users as u','u.id','=','d.user_id')
                    ->where('h.id','=',$id)
                    ->select('h.id as id','p.name as name','p.age as age', 'p.gender as gender','ad.name as address','p.centre_patient_id as ecohid' ,'u.name as dname','d.title as title','d.specialist as spcialist','d.current_work_station as work','ch.name as chamber','h.created_at as created_at')
                    ->first();
        $reports = DB::table('reports as re')
                    ->join('tests as te','te.id','=','re.test_id')
                    ->where('re.history_id','=',$id)
                    ->select('re.*','te.test_name as test','te.default_value as dvalue')
                    ->get();
        return view('view.patient.report', compact('info','reports'));
    }

    public function edit_reports($id){
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
            ->select('p.name as name','p.age as age', 'p.gender as gender','ad.name as address' ,'u.name as dname','d.title as title','d.specialist as spcialist','d.current_work_station as work','ch.name as chamber','h.id as id')
            ->first();
        $reports = Report::where('history_id',$id)->get();
        return view('view.patient.editreport', compact('info','reports','patient','history','tests'));
    }
    public function add_reports($id){
        $history = History::find($id);
        $patient = Patient::find($history->patient_id);
        $tests = Test::all();
        $giventests = explode(', ', $history->test);
        return view('view.patient.addreport', compact('history','patient','tests','giventests'));
    }
    public function reports_added(Request $request){
        $this->validate($request, [
            'result' => 'required',
        ]);
        $history_id = $request->history_id;
        $history = History::find($history_id);
        $image = $request->file('image');
        if(isset($image)){
            foreach ($request->test_id as $key => $value) {
                if(array_key_exists($key, $image) != ""){
                    $img = $image[$key];
                    $imagename = $history_id.'-'.uniqid().'.'.$img->getClientOriginalExtension();
                    if(!file_exists('images/report')){
                        mkdir('images/report', 777, true);
                    }
                    $img->move('images/report',$imagename);
                }else{
                    $imagename = "default.png";
                }


                $report = new Report();
                $report->history_id = $history_id;
                $report->test_id = $request->test_id [$key];
                $report->result = $request->result [$key];
                $report->remark = $request->remark [$key];
                $report->image = $imagename;
                $report->save();
            }
        }else{
            foreach ($request->test_id as $key => $value) {
                $report = new Report();
                $report->history_id = $history_id;
                $report->test_id = $value;
                $report->result = $request->result [$key];
                $report->remark = $request->remark [$key];
                $report->save();
            }
        }

        $history->hb = $request->hb;
        $history->esr = $request->esr;
        $history->crp = $request->crp;
        $history->wbc = $request->wbc;
        $history->neu = $request->neu;
        $history->lym = $request->lym;
        $history->gra = $request->gra;
        $history->rbc = $request->rbc;
        $history->hct = $request->hct;
        $history->mcv = $request->mcv;
        $history->mch = $request->mch;
        $history->mchc = $request->mchc;
        $history->plt = $request->plt;
        $history->chol = $request->chol;
        $history->tg = $request->tg;
        $history->glucf = $request->glucf;
        $history->glucr = $request->glucr;
        $history->gluc2hr = $request->gluc2hr;
        $history->creat = $request->creat;
        $history->ua = $request->ua;
        $history->ra = $request->ra;
        $history->ugl = $request->ugl;
        $history->upr = $request->upr;
        $history->uery = $request->uery;
        $history->uleu = $request->uleu;
        $history->ecg = $request->ecg;
        $history->usg = $request->usg;
        $history->cxr = $request->cxr;
        $history->save();
        return redirect()->route('doctor.patient.show',$history->patient_id)->with('success','Report Added Successful!');
    }

    public function selectTest(Request $request){
        $test = DB::table('tests')->where('id',$request->id)->first();
        return response()->json($test);
    }

    public function update_reports(Request $request, $id){
        $this->validate($request, [
            'result' => 'required',
        ]);
        $image = $request->file('image');
        if(isset($image)){
            foreach ($request->test_id as $key => $value) {
                $report = Report::find($request->report_id [$key]);
                if(array_key_exists($key, $image) != ""){
                    $img = $image[$key];
                    $imagename = $id.'-'.uniqid().'.'.$img->getClientOriginalExtension();
                    if (file_exists('images/report/'.$report->image)) {
                        if($report->image){  
                            unlink('images/report/'.$report->image);
                        }
                    }
                    // if(!file_exists('images/report')){
                    //     mkdir('images/report', 777, true);
                    // }
                    $img->move('images/report',$imagename);
                }else{
                    $imagename = $report->image;
                }
                $updateOrCreate = Report::updateOrCreate(
                    [
                        'history_id' => $id,
                        'test_id' => $value
                    ],
                    [
                        'result' => $request->result [$key],
                        'remark' => $request->remark [$key],
                        'image' => $imagename
                    ]
                );
            }
        }else{
            foreach ($request->test_id as $key => $value) {
                $updateOrCreate = Report::updateOrCreate(
                    [
                        'history_id' => $id,
                        'test_id' => $value
                    ],
                    [
                        'result' => $request->result [$key],
                        'remark' => $request->remark [$key],
                    ]
                );
            }
        }


        $history = History::find($id);
        $history->hb = $request->hb;
        $history->esr = $request->esr;
        $history->crp = $request->crp;
        $history->wbc = $request->wbc;
        $history->neu = $request->neu;
        $history->lym = $request->lym;
        $history->gra = $request->gra;
        $history->rbc = $request->rbc;
        $history->hct = $request->hct;
        $history->mcv = $request->mcv;
        $history->mch = $request->mch;
        $history->mchc = $request->mchc;
        $history->plt = $request->plt;
        $history->chol = $request->chol;
        $history->tg = $request->tg;
        $history->glucf = $request->glucf;
        $history->glucr = $request->glucr;
        $history->gluc2hr = $request->gluc2hr;
        $history->creat = $request->creat;
        $history->ua = $request->ua;
        $history->ra = $request->ra;
        $history->ugl = $request->ugl;
        $history->upr = $request->upr;
        $history->uery = $request->uery;
        $history->uleu = $request->uleu;
        $history->ecg = $request->ecg;
        $history->usg = $request->usg;
        $history->cxr = $request->cxr;
        $history->save();
        return redirect()->route('doctor.reports',$id)->with('success','Successfully Updated!');
    }
    public function delete_report(Request $request){
        $report = Report::find($request->report_id);

        if (file_exists('images/report/'.$report->image)) {
            if($report->image){  
                unlink('images/report/'.$report->image);
            }
        }
        $res = $report->delete();
        if ($res) {
            $message = "Deleted!";
        }else{
            $message = "Someting Wrong!";
        }

        return response()->json($message);
    }

    public function call_to_agent(Request $request){
        $agent = $request->data;
        event(new CallingEvent($agent));
    }

    public function appoint_today($today){
        $title = 'Today\'s';
        $appoints = DB::table('patient_requests as pare')
                        ->join('patients as p','p.id','=','pare.patient_id')
                        ->join('patient_infos as pi','pi.id','=','pare.patient_info_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('pare.serial_no','ASC')
                        ->where('d.user_id', Auth::user()->id)
                        ->where('pare.status',0)
                        ->where('pare.is_delete',0)
                        ->where('pare.appoint_date', 'LIKE','%'. $today .'%')
                        ->select('pare.*','p.id as pid','p.centre_patient_id as ecohid','pi.mem_type as patient_type','p.name as name','p.age as age','ad.name as address','p.blood_group as blood_group','d.id as did','u.name as dname')
                        ->get();
        return view('doctor.appoint.appoint', compact('appoints','title'));
    }
    public function all_appoint_today($today){
        $title = 'Today\'s All';
        $appoints = DB::table('patient_requests as pare')
                        ->join('patients as p','p.id','=','pare.patient_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('pare.serial_no','ASC')
                        // ->where('pare.status',0)
                        // ->where('pare.serial_no', '!=', null)
                        ->where('pare.is_delete',0)
                        ->where('pare.appoint_date', 'LIKE','%'. $today .'%')
                        ->select('pare.*','p.id as pid','p.centre_patient_id as ecohid','p.name as name','p.age as age','ad.name as address','p.blood_group as blood_group','d.id as did','u.name as dname')
                        ->get();
        return view('doctor.appoint.appoint', compact('appoints','title'));
    }

    public function appoint_by_doctor($id){
        $title = 'Appoint by Doctor';
        $doctors = Doctor::all();
        $appoints = DB::table('patient_requests as pare')
                        ->join('patients as p','p.id','=','pare.patient_id')
                        ->join('patient_infos as pi','pi.id','=','pare.patient_info_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('d.id', $id)
                        ->where('pare.status',0)
                        ->where('pare.is_delete',0)
                        ->select('pare.*','p.id as pid','p.centre_patient_id as ecohid','pi.mem_type as patient_type','p.name as name','p.age as age','ad.name as address','p.blood_group as blood_group','d.id as did','u.name as dname')
                        ->get();
        return view('doctor.appoint.appoint', compact('appoints','title','doctors'));
    }


    public function appoint_by_doctor_date(Request $request){
        $title = 'Appoint by Date';
        $appoints = DB::table('patient_requests as pare')
                        ->join('patients as p','p.id','=','pare.patient_id')
                        ->join('patient_infos as pi','pi.id','=','pare.patient_info_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('d.user_id', Auth::user()->id)
                        ->where('pare.appoint_date', 'LIKE','%'. $request->app_date .'%')
                        ->where('pare.status',0)
                        ->where('pare.is_delete',0)
                        ->select('pare.*','p.id as pid','p.centre_patient_id as ecohid','pi.mem_type as patient_type','p.name as name','p.age as age','ad.name as address','p.blood_group as blood_group','d.id as did','u.name as dname')
                        ->get();
        return view('doctor.appoint.appoint', compact('appoints','title'));
    }
}
