<?php

namespace App\Http\Controllers\Front;

use App\Model\Doctor;
use App\Model\History;
use App\Model\Patient;
use App\Model\PatientRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\Newsletter;
use App\Model\Message;
use App\Model\Blog;
use App\Model\ApptTime;
class FrontController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth' && ['admin' || 'agent' || 'doctor' || 'pharmacy' || 'user']);
    }

    public function set_appoint(Request $request){
        $this->validate($request, [
            'doctor_id' => 'required',
            'appointment_name' => 'required',
            'phone' => 'required',
            'appointment_date' => 'required',
            'appointment_time' => 'required',
        ]);

        $appt_time = new ApptTime();
        $appt_time->doctor_id = $request->doctor_id;
        $appt_time->name = $request->appointment_name;
        $appt_time->phone = $request->phone;
        $appt_time->dob = $request->dob;
        $appt_time->sex = $request->sex;
        $appt_time->marital_status = $request->marital_status;
        $appt_time->address = $request->address;
        $appt_time->blood_group = $request->blood_group;
        $appt_time->dates = $request->appointment_date;
        $appt_time->times = $request->appointment_time;
        $appt_time->status = 0;
        $appt_time->save();

        return back()->with('message','Appointent Create successful!');

    }

    public function index(){
        $doctors = Doctor::all();
        $blogs = Blog::where('status',1)->orderBy('id','DESC')->latest()->limit(3)->get();
       // return view('web.index', compact('doctors','blogs'));
        return redirect()->route('admin.dashboard');
    }

    public function about(){
        return view('web.about');
    }
    public function team(){
        return view('web.team');
    }
    public function services(){
        return view('web.services');
    }
    public function blog(){
        return view('web.blog');
    }
    public function faq(){
        return view('web.faq');
    }

    public function message(Request $request){
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'subject' => 'required|max:80',
            'message' => 'required',
        ]);
        $message = new Message();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->subject = $request->subject;
        $message->message = $request->message;
        $message->status = 0;
        $message->save();
        return back()->with('success','Your message has been successfully sent!');

    }
    public function newsletter(Request $request){
        $this->validate($request, [
            'email' => 'required|max:50',
        ]);
        $newsletter = new Newsletter();
        $newsletter->email = $request->email;
        $newsletter->status = 0;
        $message;
        try{
            $newsletter->save();
            return response('Thank you for your subscription!');
        }catch(\Exception $e){
            return response('Opps! Something went wrong.');
        }


    }
}
