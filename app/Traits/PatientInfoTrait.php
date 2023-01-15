<?php
namespace App\Traits;
use App\Model\Patient;
use App\Model\Test;
use App\Model\PatientInfo;
use Auth;
use DB;
use DataTables;
use Carbon\Carbon;
trait PatientInfoTrait{
	public function allPatient($request){

	}

	public function addPatientInfo($request){
		$pretreatment = $request->pretreatment == !null ? implode(', ', $request->pretreatment):'';
        $patient_id = $request->patient_id;
        $doctor_id = $request->doctor_id;
        $appoint_date = $request->appoint_date == null ? date('d-m-Y', strtotime(now())) : $request->appoint_date;

            $info = new PatientInfo();
            $info->user_id = Auth::user()->id;
            $info->patient_id = $patient_id;
            $info->mem_type = $request->mem_type;
            $info->edu = $request->education;
            $info->blood_presure = $request->sbp;
            $info->dbp = $request->dbp;
            $info->blood_sugar = $request->suger;
            $info->oxygen = $request->oxygen;
            $info->pulse = $request->pulse;
            $info->temp = $request->temp;
            $info->diabeties = $request->db;
            $info->hp = $request->hp;
            $info->ihd = $request->ihd;
            $info->strk = $request->strk;
            $info->copd = $request->copd;
            $info->cancer = $request->cancer;
            $info->ckd = $request->ckd;
            $info->weight = $request->weight;
            $info->height = $request->height;
            $info->edima = $request->edima;
            $info->bmi = $request->bmi == null ? 0 : $request->bmi;
            $info->anemia = $request->anemia;
            $info->heart = $request->heart;
            $info->lungs = $request->lungs;
            $info->jaundice = $request->jaundice;
            $info->salt = $request->salt;
            $info->smoke = $request->smoke;
            $info->smoking = $request->smoking;
            $info->predate = $request->predate;
            $info->predochos = $request->predochos;
            $info->presymptom = $request->presymptom;
            $info->prediagnosis = $request->prediagnosis;
            $info->pretreatment = $pretreatment;
            $info->others = $request->cc;
            $info->save();

            $info_id = DB::getPdo()->lastInsertId();

            if ($request->pretreatment) {
                foreach($request->pretreatment as $key => $value){
                    $data = array(
                        'patient_info_id' => $info_id,
                        'treatment' => $value,
                        'price_id' => $request->price_id [$key],
                        'dose_time'=>$request->dose_time [$key],
                        'dose_qty'=>$request->dose_qty [$key],
                        'dose_qty_type'=>$request->dose_qty_type [$key],
                        'dose_eat'=>$request->dose_eat [$key],
                        'dose_duration'=>$request->dose_duration [$key],
                        'dose_duration_type'=>$request->dose_duration_type [$key],
                        'created_at' => now()
                    );
                    DB::table('pre_treatments')->insert($data);
                };
            }

            if ($request->preinvestigation) {
                foreach($request->preinvestigation as $key => $value){
                    $data = array(
                        'patient_info_id' => $info_id,
                        'test_name' => $value,
                        'result' => $request->preinvresult [$key],
                        'created_at' => now()
                    );
                    DB::table('invs')->insert($data);
                };
            }
            if ($request->followinvestigation) {
                foreach($request->followinvestigation as $key => $value){
                    $data = array(
                        'patient_info_id' => $info_id,
                        'test_name' => $value,
                        'result' => $request->followinvresult [$key],
                        'created_at' => now()
                    );
                    DB::table('finvs')->insert($data);
                };
            }
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

	public function editPatientInfo($request, $id){
		$pretreatment = $request->pretreatment == !null ? implode(', ', $request->pretreatment):'';
        $info = PatientInfo::find($id);
        $info->user_id = Auth::user()->id;
        $info->patient_id = $request->patient_id;
        $info->mem_type = $request->mem_type;
        $info->edu = $request->education;
        $info->blood_presure = $request->sbp == 'null' ? '':$request->sbp;
        $info->dbp = $request->dbp == 'null' ? '':$request->dbp;
        $info->blood_sugar = $request->suger == 'null' ? '':$request->suger;
        $info->pulse = $request->pulse == 'null' ? '':$request->pulse;
        $info->temp = $request->temp == 'null' ? '':$request->temp;
        $info->diabeties = $request->db;
        $info->hp = $request->hp == 'null' ? '' : $request->hp;
        $info->ihd = $request->ihd == 'null' ? '' : $request->ihd;
        $info->strk = $request->strk == 'null' ? '' : $request->strk;
        $info->copd = $request->copd == 'null' ? '' : $request->copd;
        $info->cancer = $request->cancer == 'null' ? '' : $request->cancer;
        $info->ckd = $request->ckd == 'null' ? '' : $request->ckd;
        $info->weight = $request->weight == 'null' ? '':$request->weight;
        $info->height = $request->height == 'null' ? '':$request->height;
        $info->oxygen = $request->oxygen == 'null' ? '':$request->oxygen;
        $info->bmi = $request->bmi == 'null' ? 0 : $request->bmi;
        $info->edima = $request->edima;
        $info->anemia = $request->anemia;
        $info->heart = $request->heart == 'null' ? null : $request->heart;
        $info->lungs = $request->lungs == 'null' ? null : $request->lungs;
        $info->jaundice = $request->jaundice;
        $info->salt = $request->salt;
        $info->smoke = $request->smoke;
        $info->smoking = $request->smoking;
        $info->predate = $request->predate == 'null' ? '':$request->predate;
        $info->predochos = $request->predochos == 'null' ? '':$request->predochos;
        $info->presymptom = $request->presymptom == 'null' ? '':$request->presymptom;
        $info->prediagnosis = $request->prediagnosis == 'null' ? '':$request->prediagnosis;
        $info->pretreatment = $pretreatment;
        $info->others = $request->cc;
        $info->save();


        DB::table('pre_treatments')->where('patient_info_id',$id)->delete();
        if ($request->pretreatment) {
            foreach($request->pretreatment as $key => $value){
                $data = array(
                    'patient_info_id' => $id,
                    'treatment' => $value,
                    'price_id' => $request->price_id [$key],
                    'dose_time'=>$request->dose_time [$key],
                    'dose_qty'=>$request->dose_qty [$key],
                    'dose_qty_type'=>$request->dose_qty_type [$key],
                    'dose_eat'=>$request->dose_eat [$key],
                    'dose_duration'=>$request->dose_duration [$key],
                    'dose_duration_type'=>$request->dose_duration_type [$key],
                    'created_at' => now()
                );
                DB::table('pre_treatments')->insert($data);
            };
        }

        DB::table('invs')->where('patient_info_id',$id)->delete();
        if ($request->preinvestigation1) {
            foreach($request->preinvestigation1 as $key => $value){
                $data = array(
                        'patient_info_id' => $id,
                        'test_name' => $value,
                        'result' => $request->preinvresult1 [$key],
                        'created_at' => now()
                    );

                DB::table('invs')->insert($data);
            }
        }

        DB::table('finvs')->where('patient_info_id',$id)->delete();
        if ($request->followinvestigation1) {
            foreach($request->followinvestigation1 as $key => $value){
                $data = array(
                    'patient_info_id' => $id,
                    'test_name' => $value,
                    'result' => $request->followinvresult1 [$key],
                    'created_at' => now()
                );
                DB::table('finvs')->insert($data);
            };
        }
	}
}
