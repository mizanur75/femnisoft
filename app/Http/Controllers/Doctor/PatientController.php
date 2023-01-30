<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Model\Patient;
use App\Traits\PatientTrait;
use App\Model\Test;
use App\Model\History;
use App\Model\ApptTime;
use App\Model\PatientInfo;
use App\Model\Address;
use Auth;
use DB;
use Carbon\Carbon;

class PatientController extends Controller
{
    use PatientTrait;

    public function patient_search(Request $request){
        $title = 'Search';
        $default_value = 20;
        $search_query = $request->input('patient_search');
        $patients = Patient::where(function ($query) use ($search_query){
            $query->where('name','LIKE','%'.$search_query.'%')
            ->orWhere('centre_patient_id','LIKE','%'.$search_query.'%')
            ->orWhere('phone','LIKE','%'.$search_query.'%');
        })->paginate(20)->appends(array($search_query));
        return view('doctor.patient.all', compact('title','patients','default_value'));
    }
    public function index(Request $request)
    {
        $title = 'All';
        $default_value = 20;
        $search_value = $request->input('search_value');
        if ($search_value) {
            $default_value = $search_value;
        }

        $patients = Patient::orderBy('id','DESC')->paginate($default_value);

        // if($request->ajax())
        // {
        //     $patients = Patient::latest()->get();
        //     return DataTables::of($patients)
        //         ->addIndexColumn()
        //         ->editColumn('age', function($patients){
        //             $dob = strlen($patients->age) < 5 ? now() : $patients->age;
        //             $age = \Carbon\Carbon::parse($dob)->diff(\Carbon\Carbon::now())->format('%y');
        //             return $age;
        //         })
        //         ->editColumn('created_at', function($patients){
        //             return date('d M Y', strtotime($patients->created_at));
        //         })

        //         ->editColumn('address', function($patients){
        //             return $patients->address->name;
        //         })
        //         ->addColumn('action', function($patients){
        //             $button = '<a href="'. route('doctor.patient.show',$patients->id) .'" class="btn btn-padding btn-sm btn-info" target="_blank"><i class="fa fa-eye"></i></a>';
        //             $button .= '<a href="'. route('doctor.patient.edit',$patients->id) .'" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
        //             return $button;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        return view('doctor.patient.all', compact('title','patients','default_value'));
    }

    public function create()
    {
        $appoint = '';
        $addresses = Address::orderBy('name','ASC')->get();
        return view('view.patient.add', compact('addresses','appoint'));
    }

    public function patient_exist($id){
        $appoint = ApptTime::find($id);
        $addresses = Address::orderBy('name','ASC')->get();
        $patient = Patient::where('name','LIKE',"%$appoint->name")->where('phone',$appoint->phone)->first();
        if ($patient) {
            ApptTime::where('id', $id)->update(['status'=>1]);
            return redirect()->route('doctor.patient.show',$patient->id);
        }else{
            return view('view.patient.add_online', compact('addresses','appoint'));
        }
    }

    public function loadAddress(Request $request){
        $search = $request->search;
        if ($search) {
            $addresses = Address::select('id','name')->where('name', 'like', '%' .$search . '%')->limit(10)->get();
        }else{
            $addresses = Address::select('id','name')->limit(10)->get();

        }
        $response = array();
        foreach ($addresses as $address) {
            $response[] = array("value"=>$address->id,"label"=>$address->name);
        }
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'ecoh_id' => 'required|unique:patients,centre_patient_id',
            'name' => 'required|max:50',
            'age' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'email' => 'nullable|max:30|unique:patients,email',
            'address' => 'required',
            'uploadImage' => 'mimes:jpeg, png, jpg|max:2048',
        ]);

        
        $this->addPatient($request);
        $patient_id = DB::getPdo()->lastInsertId();

        if($request->online_appoint){
            ApptTime::where('id',$request->online_appoint)->update(['status'=>1]);
        }

        return redirect()->route('doctor.patient.show',$patient_id)->with('success','Patient Added Successfully!');
    }

    public function barcode_details(Request $request){
        $patient = Patient::where('centre_patient_id',$request->barcode)->first();
        if ($patient) {
            return redirect()->route('doctor.patient.show',$patient->id);
        }else{
            return back()->with('error','No patient found!');
        }
    }

    public function show($id)
    {
        $patient = Patient::find($id);
        $tests = Test::all();
        $patientinfos = PatientInfo::orderBy('id','DESC')->where('patient_id',$patient->id)->get();
        $appoint = DB::table('patient_requests as pare')
                        ->join('patients as p','p.id','=','pare.patient_id')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('d.user_id', Auth::user()->id)
                        ->where('pare.id', $id)
                        ->select('pare.id as pare_id','p.*','d.id as did','u.name as dname')
                        ->first();
        $histories = DB::table('histories as hi')
                        ->join('doctors as d','d.id','=','hi.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('id','DESC')
                        ->where('hi.patient_id',$patient->id)
                        ->select('hi.*','u.name as name','d.specialist as spcialist')
                        ->get();

        $appoints = DB::table('patient_requests as pare')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('pare.patient_id', $id)
                        ->orderBy('pare.id','DESC')
                        ->select('pare.*','d.id as did','u.name as dname')
                        ->get();

        $patientHeight = PatientInfo::orderBy('id','DESC')->where('patient_id',$id)->select('height')->latest()->first();

        return view('view.patient.details', compact('patient','histories','patientinfos','appoint','tests','appoints','patientHeight'));
    }


    public function edit($id)
    {
        $patient = Patient::find($id);
        $addresses = Address::orderBy('name','ASC')->get();
        return view('view.patient.edit', compact('patient','addresses'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // 'ecoh_id' => 'required|max:5|unique:patients,centre_patient_id,'.$id,
            'name' => 'required|max:50',
            'age' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'email' => 'nullable|max:30|unique:patients,email,'.$id,
            'address' => 'required',
            'uploadImage' => 'mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $this->editPatient($request, $id);
        return redirect()->route('doctor.patient.show', $id)->with('success','Patient Updated Successfully!');
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

    public function mypatient(Request $request)
    {
        $default_value = 20;
        $search_value = $request->input('search_value');
        if ($search_value) {
            $default_value = $search_value;
        }
        $patients = DB::table('histories as h')
                            ->join('patients as pt','pt.id','=','h.patient_id')
                            ->join('addresses as ad','ad.id','=','pt.address_id')
                            ->join('doctors as d','d.id','=','h.doctor_id')
                            ->where('d.user_id', Auth::user()->id)
                            ->where('h.status', 1)
                            ->orderBy('h.id','DESC')
                            ->select('pt.*','ad.name as address')
                            ->paginate($default_value);

        // if($request->ajax())
        // {
        //     $patients = DB::table('histories as h')
        //                     ->join('patients as pt','pt.id','=','h.patient_id')
        //                     ->join('addresses as ad','ad.id','=','pt.address_id')
        //                     ->join('doctors as d','d.id','=','h.doctor_id')
        //                     ->where('d.user_id', Auth::user()->id)
        //                     ->where('h.status', 1)
        //                     ->orderBy('h.id','DESC')
        //                     ->select('pt.*','ad.name as address')
        //                     ->get();
        //     return DataTables::of($patients)
        //         ->addIndexColumn()
        //         ->editColumn('age', function($patients){
        //             $birth_date = new \DateTime($patients->age);
        //             $meet_date = new \DateTime($patients->created_at);
        //             $interval = $birth_date->diff($meet_date);
        //             $days = $interval->format('%m M');
        //             $age = $interval->format('%y');
        //             if ($age == 0) {
        //                $age = $days;
        //             }
        //             return $age;
        //         })
        //         ->editColumn('created_at', function($patients){
        //             return date('d M Y', strtotime($patients->created_at));
        //         })
        //         ->addColumn('action', function($patients){
        //             $button = '<a href="'. route('doctor.patient.show',$patients->id) .'" class="btn btn-padding btn-sm btn-info" target="_blank"><i class="fa fa-eye"></i></a>';
        //             $button .= '<a href="'. route('doctor.patient.edit',$patients->id) .'" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
        //             return $button;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        return view('doctor.patient.mypatient',compact('default_value','patients'));
    }

    public function check_ecoh_id(Request $request){
        $ecoh_id = Patient::where('centre_patient_id',$request->ecoh_id)->count();
        if($ecoh_id > 0){
            $message = "exist";
        }else{
            $message = "ok";
        }
        return response()->json($message);
    }
}
