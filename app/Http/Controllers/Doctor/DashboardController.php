<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Model\Patient;
use App\Model\PatientRequest;
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
        $myappoint =  DB::table('patient_requests as pare')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->where('d.user_id', Auth::user()->id)
                        ->select('pare.*','d.user_id as did')
                        ->get();
        $prescriptions = DB::table('histories')->get();
        $myprescriptions = DB::table('histories as h')
                            ->join('doctors as d','d.id','=','h.doctor_id')
                            ->where('d.user_id', Auth::user()->id)
                            ->where('h.status', 1)
                            ->get();
        $appoints = DB::table('patient_requests as pare')
                        ->join('patients as p','p.id','=','pare.patient_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('d.user_id', Auth::user()->id)
                        ->where('pare.status','=',0)
                        ->where('pare.is_delete','=',0)
                        ->select('pare.id as id','pare.accept as accept','pare.appoint_date as appoint_date','p.id as pid','p.name as name','p.age as age','ad.name as address','p.blood_group as blood_group','d.id as did','p.centre_patient_id as centre_patient_id','u.name as dname')
                        ->get();
    	$patietns = Patient::orderBy('id','DESC')->get();
    	return view('doctor.index', compact('patietns','appoints','myappoint','myprescriptions','prescriptions'));
    }

    public function profile(){
    	$doctor = User::find(Auth::user()->id);
    	return view('doctor.profile', compact('doctor'));
    }

    public function editprofile($id){
        $doctor = User::find($id);
    	return view('doctor.editprofile', compact('doctor'));
    }

    public function updateprofile(Request $request, $id){

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            // 'password' => 'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $doctor = User::find($id);
        if(isset($image)){
            if(file_exists('images/doctor/'.$doctor->image)){
                unlink('images/doctor/'.$doctor->image);
            }
            $imagename = $slug.'-'.uniqId().'.'.$image->getClientOriginalExtension();
            if(!file_exists('images/doctor')){
                mkdir('images/doctor');
            }
            $image->move('images/doctor',$imagename);
        }else{
            $imagename = $doctor->image;
        }

        $doctor->role_id = $doctor->role_id;
        $doctor->name = $request->name;
        $doctor->slug = $slug;
        $doctor->username = $doctor->username;
        $doctor->phone = $request->phone;
        $doctor->email = $doctor->email;
        $doctor->gender = $request->gender;
        $doctor->status = 1;
        $doctor->image = $imagename;
        $doctor->password = $doctor->password;
        $doctor->save();
    	return redirect()->route('doctor.profile')->with('success','Profile Updated!');
    }


    public function status(Request $request){
        $id = Auth::user()->id;
        $user = User::find( $id);
        $user->status = $request->status;
        $user->save();
        
    }
    public function appoint(){
        $appoints = Patient::orderBy('id','DESC')->where('user_id', Auth::user()->id)->get();
        return view('doctor.appoint.appoint', compact('appoints'));
    }

    public function doctors(){
        $doctors = DB::table('users as u')
                    ->join('doctors as d','d.user_id','=','u.id')
                    ->where('u.role_id',3)
                    ->orderBy('d.id','DESC')
                    ->select('d.*','u.name as name','u.phone as phone','u.email as email')
                    ->get();
        return view('agent.doctor.all', compact('doctors'));
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
}
