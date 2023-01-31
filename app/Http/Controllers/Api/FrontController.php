<?php

namespace App\Http\Controllers\Api;

use App\Model\ApptTime;
use App\Model\Blog;
use App\Model\Service;
use App\Model\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{
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
        $appt_time->dates = $request->appointment_date;
        $appt_time->times = $request->appointment_time;
        $appt_time->status = 0;
        $appt_time->save();

        return back()->with('message','Appointent Create successful!');

    }

    public function services(){
        $services = Service::orderBy('id','DESC')->take(5)->get();
        return response()->json($services)->header("Access-Control-Allow-Origin",  "*");
    }
    public function servicesdetails($id){
        $services = Service::findOrFail($id);
        return response()->json($services)->header("Access-Control-Allow-Origin",  "*");
    }
    public function frontservices(){
        $services = Service::orderBy('id','DESC')->take(4)->get();
        return response()->json($services)->header("Access-Control-Allow-Origin",  "*");
    }
    public function blog(){
        $blog = Blog::orderBy('id','DESC')->take(16)->get();
        return response()->json($blog)->header("Access-Control-Allow-Origin",  "*");
    }
    public function blogdetails($id){
        $blog = Blog::findOrFail($id);
        return response()->json($blog)->header("Access-Control-Allow-Origin",  "*");
    }
    public function frontblog(){
        $blog = Blog::orderBy('id','DESC')->take(2)->get();
        return response()->json($blog)->header("Access-Control-Allow-Origin",  "*");
    }
    public function testimonial(){
        $blog = Review::orderBy('id','DESC')->take(10)->get();
        return response()->json($blog)->header("Access-Control-Allow-Origin",  "*");
    }
}
