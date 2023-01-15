<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Pharmacy;
use App\Model\PatientRequest;
use App\Model\History;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        
        $current_date = now()->format('d');
    	$last_date = \Carbon\Carbon::now()->daysInMonth;

    	// if ($last_date - $current_date == 5 || $last_date - $current_date == 4 || $last_date - $current_date == 3 || $last_date - $current_date == 2 || $last_date - $current_date == 1) {
    	// 	DB::table('users')->where('id', Auth::user()->id)->update(['payment' => 2]);
    	// }
        $patients = Patient::all();
        $doctors = User::where('role_id',3)->count();
        $avldoctors = Doctor::all();
        $total_appoint = PatientRequest::select('is_delete','done','status')->get();
        $pres = History::select('status')->get();
        $appoints = DB::table('patient_requests as pare')
                        ->join('doctors as doc','doc.id','=','pare.doctor_id')
                        ->join('patients as pat','pat.id','=','pare.patient_id')
                        ->join('addresses as ad','ad.id','=','pat.address_id')
                        ->join('users as u','u.id','=','doc.user_id')
                        ->orderBy('pare.id','DESC')
                        ->where('pare.status',0)
                        ->where('pare.is_delete',0)
                        ->select('pare.*','pat.name as pname','ad.name as address','u.name as dname','doc.specialist as spc')
                        ->limit(10)
                        ->get();
        return view('agent.index', compact('patients','doctors','appoints','avldoctors','total_appoint','pres'));
    }

    public function doctor(){
    	$doctors = DB::table('users as u')
                    ->join('doctors as d','d.user_id','=','u.id')
                    ->where('u.role_id',3)
                    ->orderBy('d.id','DESC')
                    ->select('d.*','u.name as name','u.phone as phone','u.email as email')
                    ->get();
        return view('agent.doctor.all',compact('doctors'));
    }
    public function doctorshow($id){
        $doctor = DB::table('doctors as d')
                        ->join('users as u','u.id','=','d.user_id')
                        ->join('chambers as ch','ch.id','=','d.chamber_id')
                        ->where('d.id',$id)
                        ->select('d.*','u.name as name','u.email as email','u.phone as phone','u.gender as gender','ch.name as chamber')
                        ->first();

        return response()->json($doctor);
    }

    public function pharmacy(){
        $pharmacies = Pharmacy::orderBy('id','DESC')->where('status',1)->get();
        return view('agent.pharmacy.all', compact('pharmacies'));
    }
}
