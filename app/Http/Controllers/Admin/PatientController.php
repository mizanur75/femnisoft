<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Patient;
use App\Model\PatientInfo;
use Auth;
use DB;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function index()
    {
        $patients = Patient::orderBy('id','DESC')->get();
        return view('admin.patient.all', compact('patients'));
    }


    public function create()
    {
        return view('admin.patient.add');
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:50',
            'age' => 'required|max:10',
            'gender' => 'required',
            'marital_status' => 'required',
            'address' => 'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        if (isset($image)) {
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!file_exists('images/patient')) {
                mkdir('images/patient', 777, true);
            }
            $image->move('images/patient',$imagename);
        }else{
            $imagename = 'default.png';
        }

        $patient = new Patient();
        $patient->user_id = Auth::user()->id;
        $patient->name = $request->name;
        $patient->age = $request->age;
        $patient->phone = $request->phone;
        $patient->email = $request->email;
        $patient->gender = $request->gender;
        $patient->marital_status = $request->marital_status;
        $patient->address = $request->address;
        $patient->blood_group = $request->blood_group;
        $patient->blood_presure = $request->blood_presure;
        $patient->blood_sugar = $request->blood_sugar;
        $patient->pulse = $request->pulse;
        $patient->injury = $request->injury;
        $patient->image = $imagename;
        $patient->slug = $slug;
        $patient->status = $request->status;
        $patient->save();

        return redirect()->route('admin.patient.index')->with('success','Patient Added Successfully!');
    }

    public function show($id)
    {
        $id = \Crypt::decrypt($id);
        if ($id == true) {
            $histories = DB::table('histories as hi')
                        ->join('doctors as d','d.id','=','hi.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('id','DESC')
                        ->where('hi.patient_id',$id)
                        ->select('hi.*','u.name as name','d.specialist as spcialist')
                        ->get();
            $patient = Patient::find($id);
            $patientinfos = PatientInfo::orderBy('id','DESC')->where('patient_id',$id)->get();
            return view('admin.patient.details', compact('patient','patientinfos','histories'));
        }else{
            return back();
        }
        
    }

    public function edit($id)
    {
        $patient = Patient::find($id);
        return view('admin.patient.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'age' => 'required|max:10',
            'gender' => 'required',
            'marital_status' => 'required',
            'address' => 'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $patient = Patient::find($id);
        if (isset($image)) {
            if (file_exists('images/patient/'.$patient->image)) {
                unlink('images/patient/'.$patient->image);
            }
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!file_exists('images/patient')) {
                mkdir('images/patient', 777, true);
            }
            $image->move('images/patient',$imagename);
        }else{
            $imagename = $patient->image;
        }

        
        $patient->user_id = $patient->user_id;
        $patient->name = $request->name;
        $patient->age = $request->age;
        $patient->phone = $request->phone;
        $patient->email = $request->email;
        $patient->gender = $request->gender;
        $patient->marital_status = $request->marital_status;
        $patient->address = $request->address;
        $patient->blood_group = $request->blood_group;
        $patient->blood_presure = $request->blood_presure;
        $patient->blood_sugar = $request->blood_sugar;
        $patient->pulse = $request->pulse;
        $patient->injury = $request->injury;
        $patient->image = $imagename;
        $patient->slug = $slug;
        $patient->status = $request->status;
        $patient->save();

        return redirect()->route('admin.patient.index')->with('success','Patient Updated Successfully!');
    }

    public function destroy($id)
    {
        $patient = Patient::find($id);
        if (file_exists('images/patient/'.$patient->image)) {
            unlink('images/patient/'.$patient->image);
        }
        $patient->delete();
        return back()->with('success','Patient Deleted!');
    }
}
