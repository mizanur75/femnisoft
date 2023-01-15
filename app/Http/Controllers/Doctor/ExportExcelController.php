<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Excel;
use App\Exports\DataExport;
use App\Model\Patient;
use Illuminate\Support\Facades\Input;

class ExportExcelController extends Controller
{
    function export_search(Request $request){
        $start = '';
        $finish = '';
        $check_ecohid = Patient::where('centre_patient_id',$request->ecohid)->first();
        if ($check_ecohid) {
            $count = DB::table('histories as hi')
            ->join('doctors as d','d.id','=','hi.doctor_id')
            ->join('patients as p','p.id','=','hi.patient_id')
            ->join('addresses as ad','ad.id','=','p.address_id')
            ->join('patient_infos as pi','pi.id','=','hi.patient_info_id')
            ->join('users as u','u.id','=','d.user_id')
            ->where('p.centre_patient_id',$request->ecohid)
            ->orderBy('hi.id','DESC')
            ->select('hi.id as hid')
            ->count();

            $patient_data = DB::table('histories as hi')
            ->join('doctors as d','d.id','=','hi.doctor_id')
            ->join('patients as p','p.id','=','hi.patient_id')
            ->join('addresses as ad','ad.id','=','p.address_id')
            ->join('patient_infos as pi','pi.id','=','hi.patient_info_id')
            ->join('users as u','u.id','=','d.user_id')
            ->where('p.centre_patient_id',$request->ecohid)
            ->orderBy('hi.id','DESC')
            ->where('hi.status',1)
            ->select('hi.id as hid','hi.created_at as visit_date','hi.diagnosis as diagnosis','hi.sec_diagnosis as sec_diagnosis','hi.sec_dx2 as sec_dx2','u.name as dname','p.name as patient_name','p.age as dob','p.reg_mem as reg_mem','p.gender as sex','ad.name as address','p.centre_patient_id as ecohid','pi.*','hi.esr as esr','hi.crp as crp','hi.wbc as wbc','hi.neu as neu','hi.gra as gra','hi.rbc as rbc','hi.hb as hb','hi.hct as hct','hi.mcv as mcv','hi.mch as mch','hi.mchc as mchc','hi.mchc as mchc','hi.plt as plt','hi.lym as lym','p.blood_group as blood_group','hi.chol as chol','hi.tg as tg','hi.glucf as glucf','hi.glucr as glucr','hi.gluc2hr as gluc2hr','hi.creat as creat','hi.ua as ua','hi.ra as ra','hi.ugl as ugl','hi.upr as upr','hi.uery as uery','hi.uleu as uleu','hi.ecg as ecg','hi.usg as usg','hi.cxr as cxr','hi.visit as visit','hi.app_fee as app_fee','hi.lab_fee as lab_fee')
            ->paginate(10);
            if($count > 0){
            return view('view.export_excel', compact('patient_data','start','finish'));
            }else{
                return back()->with('danger','Opps! Record Not Found');
            }  
        }else{
            return back()->with('danger','ECOH ID Not Found');
        }
        
    }
    function index(){
        $start = '';
        $finish = '';
        $patient_data = DB::table('histories as hi')
            ->join('doctors as d','d.id','=','hi.doctor_id')
            ->join('patients as p','p.id','=','hi.patient_id')
            ->join('addresses as ad','ad.id','=','p.address_id')
            ->join('patient_infos as pi','pi.id','=','hi.patient_info_id')
            ->join('users as u','u.id','=','d.user_id')
            ->orderBy('hi.id','DESC')
            ->where('hi.status',1)
            ->select('hi.id as hid','hi.created_at as visit_date','hi.diagnosis as diagnosis','hi.sec_diagnosis as sec_diagnosis','hi.sec_dx2 as sec_dx2','u.name as dname','p.name as patient_name','p.age as dob','p.reg_mem as reg_mem','p.gender as sex','ad.name as address','p.centre_patient_id as ecohid','pi.*','hi.esr as esr','hi.crp as crp','hi.wbc as wbc','hi.neu as neu','hi.gra as gra','hi.rbc as rbc','hi.hb as hb','hi.hct as hct','hi.mcv as mcv','hi.mch as mch','hi.mchc as mchc','hi.mchc as mchc','hi.plt as plt','hi.lym as lym','p.blood_group as blood_group','hi.chol as chol','hi.tg as tg','hi.glucf as glucf','hi.glucr as glucr','hi.gluc2hr as gluc2hr','hi.creat as creat','hi.ua as ua','hi.ra as ra','hi.ugl as ugl','hi.upr as upr','hi.uery as uery','hi.uleu as uleu','hi.ecg as ecg','hi.usg as usg','hi.cxr as cxr','hi.visit as visit','hi.app_fee as app_fee','hi.lab_fee as lab_fee')
            ->paginate(10);
        return view('view.export_excel', compact('patient_data','start','finish'));
    }

    function excel(){
        return Excel::download(new DataExport, 'OPD_DATA.xlsx');
    }
}
