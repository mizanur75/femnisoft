<?php
namespace App\Traits;
use App\Model\Patient;
use App\Model\Test;
use App\Model\Address;
use App\Model\PatientInfo;
use Auth;
use DB;
use DataTables;
use Carbon\Carbon;
trait PatientTrait{
	public function allPatient($request){
        
	}

	public function addPatient($request){
        if (strlen($request->age) < 4) {
            $age = date('d-m-Y', strtotime(Carbon::now()->subYears($request->age)));
        }elseif(strlen($request->age) == 4){
            $birth_year = date('d-m-Y', strtotime($request->age));
            $now = date('d-m-Y', strtotime(Carbon::now()));
            $birth_date = new \DateTime($birth_year);
            $current = new \DateTime($now);
            $interval = $birth_date->diff($current);
            $year = $interval->format('%y');;
            $age = date('d-m-Y', strtotime(Carbon::now()->subYears($year)));
        }else{
            $age = $request->age;
        }

        $address = Address::where('name',$request->address)->first();
        if ($address) {
            $address_id = $address->id;
        }else{
            $address = new Address();
            $address->create_userid = Auth::user()->id;
            $address->name = $request->address;
            $address->save();
            $address_id = DB::getPdo()->lastInsertId();
        }
        $slug = str_slug($request->name);
        if ($request->webcamImage) {
            $imagename = $slug.'-'.uniqid().'.'.explode('/', explode(':', substr($request->webcamImage, 0, strpos($request->webcamImage, ';')))[1])[1];
            \Image::make($request->webcamImage)->save(public_path('images/patient/').$imagename);
        }else{
            if($request->hasFile('uploadImage')) {
                $image       = $request->file('uploadImage');
                $imagename    = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();

                $image_resize = \Image::make($image->getRealPath());              
                $image_resize->resize(245, 245);
                $image_resize->save(public_path('images/patient/'.$imagename));

            }else{
                $imagename = '';
            }
        }

        $patient = new Patient();
        $patient->user_id = Auth::user()->id;
        $patient->centre_patient_id = mt_rand(10000,99999);
        $patient->reg_mem = $request->reg_mem;
        $patient->name = $request->name;
        $patient->age = $age;
        $patient->phone = $request->phone;
        $patient->email = $request->email;
        $patient->gender = $request->gender;
        $patient->marital_status = $request->marital_status;
        $patient->address_id = $address_id;
        $patient->blood_group = $request->blood_group;
        $patient->blood_presure = $request->blood_presure;
        $patient->blood_sugar = $request->blood_sugar;
        $patient->pulse = $request->pulse;
        $patient->injury = $request->injury;
        $patient->image = $imagename;
        $patient->slug = $slug;
        $patient->status = $request->status;
        $patient->save();
	}

	public function patientDetails($id){
		$histories = DB::table('histories as hi')
                        ->join('doctors as d','d.id','=','hi.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('id','DESC')
                        ->where('hi.patient_id',$id)
                        ->select('hi.*','u.name as name','d.specialist as spcialist')
                        ->get();
        $patient = Patient::find($id);
        $tests = Test::all();
        $patientinfos = PatientInfo::orderBy('id','DESC')->where('patient_id',$id)->get();
        $appoints = DB::table('patient_requests as pare')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('pare.patient_id', $id)
                        ->orderBy('pare.id','DESC')
                        ->select('pare.*','d.id as did','u.name as dname')
                        ->get();
        return ['histories' => $histories, 'patient' => $patient, 'tests' => $tests, 'patientinfos' => $patientinfos, 'appoints' => $appoints];
	}

	public function editPatient($request, $id){
		$slug = str_slug($request->name);
		$patient = Patient::find($id);

		if (strlen($request->age) < 4) {
            $age = date('d-m-Y', strtotime(Carbon::now()->subYears($request->age)));
        }elseif(strlen($request->age) == 4){
            $birth_year = date('d-m-Y', strtotime($request->age));
            $now = date('d-m-Y', strtotime(Carbon::now()));
            $birth_date = new \DateTime($birth_year);
            $current = new \DateTime($now);
            $interval = $birth_date->diff($current);
            $year = $interval->format('%y');;
            $age = date('d-m-Y', strtotime(Carbon::now()->subYears($year)));
        }else{
            $age = $request->age;
        }

		if ($request->webcamImage) {
		    if ($patient->image == !null) {
		        unlink('images/patient/'.$patient->image);
		    }
		    $imagename = $slug.'-'.uniqid().'.'.explode('/', explode(':', substr($request->webcamImage, 0, strpos($request->webcamImage, ';')))[1])[1];
		    \Image::make($request->webcamImage)->save(public_path('images/patient/').$imagename);
		}else{
            if($request->hasFile('uploadImage')) {
                if ($patient->image == !null) {
                    unlink('images/patient/'.$patient->image);
                }
                $image       = $request->file('uploadImage');
                $imagename    = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();

                $image_resize = \Image::make($image->getRealPath());              
                $image_resize->resize(245, 245);
                $image_resize->save(public_path('images/patient/'.$imagename));

            }else{
                $imagename = $patient->image;
            }
		}

		$patient->user_id = $patient->user_id;
		$patient->reg_mem = $request->reg_mem;
		$patient->name = $request->name;
		$patient->age = $age;
		$patient->phone = $request->phone;
		$patient->email = $request->email;
		$patient->gender = $request->gender;
		$patient->marital_status = $request->marital_status;
		$patient->address_id = $request->address;
		$patient->blood_group = $request->blood_group;
		$patient->blood_presure = $request->blood_presure;
		$patient->blood_sugar = $request->blood_sugar;
		$patient->pulse = $request->pulse;
		$patient->injury = $request->injury;
		$patient->image = $imagename;
		$patient->slug = $slug;
		$patient->status = $request->status;
		$patient->save();
	}
}