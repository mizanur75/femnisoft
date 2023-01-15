<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Input;
use DB;

class DataExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if (Input::get('start') == null) {
            $start = '';
        }else{
            $start = date('Y-m-d', strtotime(Input::get('start')));
        }
        if (Input::get('finish') == null) {
            $finish = '';
        }else{
            $finish = date('Y-m-d', strtotime(Input::get('finish')));
        }
        if ($start == null && $finish == null) {
            $patient = DB::table('histories as hi')
            ->join('doctors as d','d.id','=','hi.doctor_id')
            ->join('patients as p','p.id','=','hi.patient_id')
            ->join('addresses as ad','ad.id','=','p.address_id')
            ->join('patient_infos as pi','pi.id','=','hi.patient_info_id')
            ->join('users as u','u.id','=','d.user_id')
            ->orderBy('hi.id','DESC')
            ->where('hi.status',1)
            ->select(\DB::raw('DATE_FORMAT(hi.created_at, "%d-%b-%Y") as visit_date'),'hi.visit as visit','p.centre_patient_id as ecohid','pi.mem_type as mem_type','p.name as patient_name','hi.age as age',\DB::raw('IF((p.gender = 0),"M","F") as sex'),'pi.edu as edu','ad.name as address','u.name as dname','hi.diagnosis as diagnosis','hi.sec_diagnosis as sec_diagnosis','hi.sec_dx2 as sec_dx2','pi.blood_presure as blood_presure','pi.dbp as dbp','pi.pulse as pulse','pi.oxygen as oxygen','pi.temp as temp','pi.height as height','pi.weight as weight',\DB::raw('IF((hi.age >= 15), pi.bmi,"") as bmi'),'pi.edima as edima','pi.anemia as anemia','pi.heart as heart','pi.lungs as lungs','pi.jaundice as jaundice','pi.hp as hp','pi.diabeties as diabeties','pi.ihd as ihd','pi.strk as strk','pi.copd as copd','pi.cancer as cancer','pi.ckd as ckd','pi.salt as salt','pi.smoke as smoke','pi.smoking as smoking','hi.wbc as wbc','hi.lym as lym','hi.gra as gra','hi.rbc as rbc','hi.hb as hb','hi.hct as hct','hi.mcv as mcv','hi.mch as mch','hi.mchc as mchc','hi.plt as plt','hi.esr as esr','hi.neu as neu','p.blood_group as blood_group','hi.chol as chol','hi.tg as tg','hi.glucf as glucf','hi.glucr as glucr','hi.gluc2hr as gluc2hr','hi.creat as creat','hi.ua as ua','hi.crp as crp','hi.ra as ra','hi.ugl as ugl','hi.upr as upr','hi.uery as uery','hi.uleu as uleu','hi.ecg as ecg','hi.usg as usg','hi.cxr as cxr')
            ->get();
        }else{
            $patient = DB::table('histories as hi')
            ->join('doctors as d','d.id','=','hi.doctor_id')
            ->join('patients as p','p.id','=','hi.patient_id')
            ->join('addresses as ad','ad.id','=','p.address_id')
            ->join('patient_infos as pi','pi.id','=','hi.patient_info_id')
            ->join('users as u','u.id','=','d.user_id')
            ->orderBy('hi.id','DESC')
            ->where('hi.status',1)
            ->whereBetween('hi.created_at', [$start." 00:00:00", $finish." 23:59:59"])
            ->select(\DB::raw('DATE_FORMAT(hi.created_at, "%d-%b-%Y") as visit_date'),'hi.visit as visit','p.centre_patient_id as ecohid','pi.mem_type as mem_type','p.name as patient_name','hi.age as age',\DB::raw('IF((p.gender = 0),"M","F") as sex'),'pi.edu as edu','ad.name as address','u.name as dname','hi.diagnosis as diagnosis','hi.sec_diagnosis as sec_diagnosis','hi.sec_dx2 as sec_dx2','pi.blood_presure as blood_presure','pi.dbp as dbp','pi.pulse as pulse','pi.oxygen as oxygen','pi.temp as temp','pi.height as height','pi.weight as weight',\DB::raw('IF((hi.age >= 15), pi.bmi,"") as bmi'),'pi.edima as edima','pi.anemia as anemia','pi.heart as heart','pi.lungs as lungs','pi.jaundice as jaundice','pi.hp as hp','pi.diabeties as diabeties','pi.ihd as ihd','pi.strk as strk','pi.copd as copd','pi.cancer as cancer','pi.ckd as ckd','pi.salt as salt','pi.smoke as smoke','pi.smoking as smoking','hi.wbc as wbc','hi.lym as lym','hi.gra as gra','hi.rbc as rbc','hi.hb as hb','hi.hct as hct','hi.mcv as mcv','hi.mch as mch','hi.mchc as mchc','hi.plt as plt','hi.esr as esr','hi.neu as neu','p.blood_group as blood_group','hi.chol as chol','hi.tg as tg','hi.glucf as glucf','hi.glucr as glucr','hi.gluc2hr as gluc2hr','hi.creat as creat','hi.ua as ua','hi.crp as crp','hi.ra as ra','hi.ugl as ugl','hi.upr as upr','hi.uery as uery','hi.uleu as uleu','hi.ecg as ecg','hi.usg as usg','hi.cxr as cxr')
            ->get();
        }

        return $patient;
    }
    public function headings(): array
    {
        return [
            'Date','Visit','ECOH ID','Pt. Type','Patient Name','Age','Sex','Edu','Address','Doctor Name','Pri. Dx','Sec. Dx1','Sec. dx2','SBP','DBP','Pulse','Oxy','Temp','Ht','Wt','BMI','Edema','Anemia','Heart','Lungs','Jaundice','HTN','DM','IHD','STRK','COPD','Cancer','CKD','Salt','SLT','Smoking','WBC','%LYM','GRA%','RBC','HGB','HCT','MCV','MCH','MCHC','PLT','ESR','%Neu','Bl-group','Chol','TG','Gluc-f','Gluc-r','Gluc-2hr','Creat','UA','CRP','RA','U-gl','U-pr','U-ery','U-leu','ECG','USG','CXR'
        ];
    }

}
