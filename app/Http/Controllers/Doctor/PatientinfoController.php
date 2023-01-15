<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Events\NotificationEvent;
use App\Model\Doctor;
use App\Model\History;
use App\Model\PatientInfo;
use App\Traits\PatientInfoTrait;
use App\Model\Inv;
use App\Model\Finv;
use App\Model\AppInvoice;
use App\Model\Patient;
use App\Model\Chamber;
use App\Model\PreTreatment;
use App\Model\PatientRequest;
use Auth;
use DB;
use Illuminate\Http\Request;

class PatientinfoController extends Controller
{
    use PatientInfoTrait;
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->addPatientInfo($request);

        return back()->with('success','Successfully Added!');
    }

    public function show($id)
    {
        $info = PatientInfo::find($id);
        $pretreatment = PreTreatment::where('patient_info_id',$info->id)->get();
        $editpreinv = Inv::where('patient_info_id',$info->id)->get();
        $editfinv = Finv::where('patient_info_id',$info->id)->get();
        return response()->json(['data'=>[$info,$editpreinv,$pretreatment,$editfinv]]);
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        $this->editPatientInfo($request, $id);

        return back()->with('success','Successfully Edited!');
    }

    public function destroy($id)
    {
        PatientInfo::find($id)->delete();
        return back()->with('success','Deleted Successful!');
    }
    public function payrequest($doctor_id, $patient_id){
        $chambers = Chamber::all();
        $patient = Patient::find($patient_id);
        $patient_info = PatientInfo::where('patient_id',$patient_id)->select('id')->latest()->first();
        $doctors = DB::table('doctors as d')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('d.status',1)
                        ->where('d.id',$doctor_id)
                        ->select('d.*','u.name as name')
                        ->get();
        return redirect()->route('doctor.sendrequest',[$doctor_id, $patient_id]);
        // return view("view.patient.doctors_pay_request", compact('doctors','chambers','patient','patient_info'));
    }
    public function sendrequest(Request $request, $doctor_id, $patient_id){
        $appoint_date = $request->appoint_date == null ? date('d-m-Y', strtotime(now())) : $request->appoint_date;
        $check = PatientRequest::where('doctor_id',$doctor_id)->where('patient_id',$patient_id)->where('status',0)->where('is_delete',0)->first();
        if(empty($check) === true){
                $prequest = new PatientRequest();
                $prequest->user_id = Auth::user()->id;
                $prequest->doctor_id = $doctor_id;
                $prequest->patient_id = $patient_id;
                $prequest->appoint_date = $appoint_date;
                $prequest->save();

                $app_id = DB::getPdo()->lastInsertId();
                $serial = PatientRequest::where('appoint_date',\Carbon\Carbon::parse()->format('d-m-Y'))->where('doctor_id',$doctor_id)->max('serial_no');
                $serial += 1;
                PatientRequest::where('id',$app_id)->update(['serial_no'=>$serial]);

                $doctor = Doctor::find($doctor_id);
                DB::table('patient_requests')->where('id',$app_id)->update(['accept'=>1]);
                return redirect()->route('doctor.prescription.edit',$app_id);
            // });

        }elseif(!empty($check) && $check->accept == 1 && $check->done == 0){

            toastr('Your Request has been accpted! Please wait.','warning');
            return back();

        }elseif(!empty($check) && $check->accept == 1 && $check->done == 1){

            toastr('Doctor Advice Some tests! Please done it.','warning');
            return back();

        }else{

            toastr('You have already send a request','error');
            return back();

        }
    }
}
