<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Chamber;
use App\User;
use Auth;
Use DB;
use Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        $id = Auth::user()->id;
        $current_date = now()->format('d');
        $last_date = \Carbon\Carbon::now()->daysInMonth;
        if(Doctor::where('user_id',$id)->count()>0){
        $doctor = DB::table('doctors as d')
                    ->join('users as u','u.id','=','d.user_id')
                    ->join('chambers as ch','ch.id','=','d.chamber_id')
                    ->where('d.user_id',Auth::user()->id)
                    ->select('d.*','u.name as name','u.email as email','u.phone as phone','u.payment as is_payment','u.amount as amount','ch.name as chamber','ch.address as chamber_address','ch.post_code as chamber_post_code')
                    ->first();
        }else{
            $doctor = User::find($id);
        }
        $now = date('Y-m-d', strtotime(now()));
        $patients = DB::table('histories as h')
                            ->join('patients as pt','pt.id','=','h.patient_id')
                            ->join('doctors as d','d.id','=','h.doctor_id')
                            ->join('addresses as ad','ad.id','=','pt.address_id')
                            ->where('d.user_id', Auth::user()->id)
                            ->where('h.status', 1)
                            ->where('h.created_at', 'LIKE', '%'. $now . '%')
                            ->orderBy('h.id','DESC')
                            ->select('h.*','pt.*','ad.name as address')
                            ->get();
        return view('doctor.profile', compact('doctor','patients','current_date','last_date'));
    }

    public function create()
    {
        $chambers = Chamber::all();
        return view('doctor.createprofile',compact('chambers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'specialist' => 'required',
            'education' => 'required',
            'regi_no' => 'required',
            'experience' => 'required',
            // 'work_station' => 'required',
            'chamber_id' => 'required',
        ]);
        $image = $request->file('image');
        $signature = $request->file('signature');
        $slug = Auth::user()->id;
        
        if(isset($image)){
            $imagename = $slug.'-'.uniqId().'.'.$image->getClientOriginalExtension();
            if(!file_exists('images/doctor')){
                mkdir('images/doctor');
            }
            $image->move('images/doctor',$imagename);
        }else{
            $imagename = 'default.png';
        }

        if(isset($signature)){
            $signaturename = $slug.'-'.uniqId().'.'.$signature->getClientOriginalExtension();
            if(!file_exists('images/signature')){
                mkdir('images/signature');
            }
            $signature->move('images/signature',$signaturename);
        }else{
            $signaturename = 'default.png';
        }

        $doctor = new Doctor();
        $doctor->user_id = Auth::user()->id;
        $doctor->title = $request->title;
        $doctor->specialist = $request->specialist;
        $doctor->education = $request->education;
        $doctor->regi_no = $request->regi_no;
        $doctor->experience = $request->experience;
        $doctor->current_work_station = $request->work_station;
        $doctor->chamber_id = $request->chamber_id;
        $doctor->image = $imagename;
        $doctor->signature = $signaturename;
        $doctor->save();
        return redirect()->route('doctor.profile.index')->with('success','Profile Created!');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $chambers = Chamber::all();
        $doctor = DB::table('users as u')
                    ->join('doctors as d','d.user_id','=','u.id')
                    ->where('d.user_id','=',$id)
                    ->select('u.name as name','d.*')
                    ->first();
        return view('doctor.editprofile', compact('doctor','chambers'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'specialist' => 'required',
            'education' => 'required',
            'regi_no' => 'required',
            'experience' => 'required',
            // 'work_station' => 'required',
            'chamber_id' => 'required',
        ]);
        $image = $request->file('image');
        $signature = $request->file('signature');
        $slug = Auth::user()->id;

        $doctor = Doctor::where('user_id',$id)->first();
        if(isset($image)){
            if(file_exists('images/doctor/'.$doctor->image)){
                unlink('images/doctor/'.$doctor->image);
            }
            $imagename = $id.'-'.uniqId().'.'.$image->getClientOriginalExtension();
            if(!file_exists('images/doctor')){
                mkdir('images/doctor');
            }
            $image->move('images/doctor',$imagename);
        }else{
            $imagename = $doctor->image;
        }

        if(isset($signature)){
            if(file_exists('images/signature/'.$doctor->signature)){
                unlink('images/signature/'.$doctor->signature);
            }
            $signaturename = $slug.'-'.uniqId().'.'.$signature->getClientOriginalExtension();
            if(!file_exists('images/signature')){
                mkdir('images/signature');
            }
            $signature->move('images/signature',$signaturename);
        }else{
            $signaturename = $doctor->signature;
        }

        DB::table('doctors')->where('user_id','=',$id)
            ->update([
                'title' => $request->title,
                'specialist' => $request->specialist,
                'education' => $request->education,
                'regi_no' => $request->regi_no,
                'experience' => $request->experience,
                'current_work_station' => $request->work_station,
                'chamber_id' => $request->chamber_id,
                'image' => $imagename,
                'signature' => $signaturename,
            ]);
        return redirect()->route('doctor.profile.index')->with('success','Profile Updated!');
    }

    public function destroy($id)
    {
        //
    }

    public function status(Request $request){
        $id = Auth::user()->id;
        DB::table('doctors')->where('user_id','=',$id )->update(['status'=>$request->status]);
    }

    public function password_change(){
        $doctor = DB::table('users as u')
                    ->join('doctors as d','d.user_id','=','u.id')
                    ->where('d.user_id','=',Auth::user()->id)
                    ->select('u.name as name','d.*')
                    ->first();
        return view('doctor.password', compact('doctor'));
    }
    public function password_changed(Request $request){

        $hashedPassword = Auth::user()->password;
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed'
        ]);
        if (Hash::check($request->old_password , $hashedPassword )) {
            if (!Hash::check($request->password , $hashedPassword)) {
 
                $user = User::find(Auth::user()->id);
                $password = bcrypt($request->password);
                User::where('id',Auth::user()->id)->update(['password' =>  $password]);

                session()->flash('message','Password updated successfully');
                return redirect()->back();
            }else{
                session()->flash('danger','New password can not be the old password!');
                return redirect()->back();
            }
 
        }else{
            session()->flash('danger','Old password doesn\'t matched ');
            return redirect()->back();
        }
    }
}
