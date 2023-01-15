<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Model\Doctor;
use App\Model\Report;
use App\Model\History;

class PageController extends Controller
{
    public function pre_history(Request $request){
    	$history = DB::table('histories as hi')
    				->join('doctors as d','d.id','=','hi.doctor_id')
    				->join('users as u','u.id','=','d.user_id')
    				->where('patient_id',$request->patient_id)
    				->select('hi.*','u.name as dname')
    				->orderBy('hi.id','DESC')
    				->first();
    	if($history){
            $preinvestigation = DB::table('reports as r')
                ->join('tests as t','t.id','=','r.test_id')
                ->where('history_id',$history->id)
                ->select('t.id as id','t.test_name as test_name','r.result as result')
                ->get();
            $treatments = DB::table('prescriptions as pre')
                ->join('histories as h','h.id','=','pre.history_id')
                ->join('prices as pr','pr.id','=','pre.price_id')
                ->join('types as tp','tp.id','=','pr.type_id')
                ->join('medicines as med','med.id','=','pr.medicine_id')
                ->join('generics as gn','gn.id','=','med.generic_id')
                ->where('pre.history_id', $history->id)
                ->where('pre.qty', 1)
                ->select('pre.*','med.name as medname','tp.name as cat')
                ->orderBy('pre.id','DESC')
                ->get();
        }else{
            $preinvestigation = '';
            $treatments = '';
        }

    	return response()->json(['data' => [$history,$preinvestigation,$treatments]]);
    }

    public function display_appoint(){
        $title = 'Today\'s';
        $today = \Carbon\Carbon::parse()->format('d-m-Y');
        $appoints = DB::table('patient_requests as pare')
                        ->join('patients as p','p.id','=','pare.patient_id')
                        ->join('patient_infos as pi','pi.id','=','pare.patient_info_id')
                        ->join('addresses as ad','ad.id','=','p.address_id')
                        ->join('doctors as d','d.id','=','pare.doctor_id')
                        ->join('users as u','u.id','=','d.user_id')
                        ->orderBy('pare.serial_no','ASC')
                        ->where('pare.status',0)
                        ->where('pare.is_delete',0)
                        ->where('pare.appoint_date', 'LIKE','%'. $today .'%')
                        ->select('pare.*','p.id as pid','p.centre_patient_id as ecohid','pi.mem_type as patient_type','p.name as name','p.age as age','ad.name as address','p.blood_group as blood_group','d.id as did','u.name as dname')
                        ->get();
        return view('view.display_appoint', compact('appoints','title'));
    }

    public function getReportForExport($history_id){
        $history = History::find($history_id);
        return response($history);
    }
    public function reportForFollowUpExportUpdate(Request $request){
        $history = History::find($request->history_id);
        $history->hb = $request->hb;
        $history->esr = $request->esr;
        $history->crp = $request->crp;
        $history->wbc = $request->wbc;
        $history->neu = $request->neu;
        $history->lym = $request->lym;
        $history->gra = $request->gra;
        $history->rbc = $request->rbc;
        $history->hct = $request->hct;
        $history->mcv = $request->mcv;
        $history->mch = $request->mch;
        $history->mchc = $request->mchc;
        $history->plt = $request->plt;
        $history->chol = $request->chol;
        $history->tg = $request->tg;
        $history->glucf = $request->glucf;
        $history->glucr = $request->glucr;
        $history->gluc2hr = $request->gluc2hr;
        $history->creat = $request->creat;
        $history->ua = $request->ua;
        $history->ra = $request->ra;
        $history->ugl = $request->ugl;
        $history->upr = $request->upr;
        $history->uery = $request->uery;
        $history->uleu = $request->uleu;
        $history->ecg = $request->ecg;
        $history->usg = $request->usg;
        $history->cxr = $request->cxr;
        $history->save();
        if (Auth::user()->role->name == 'Doctor') {
            $route = 'doctor.allprescription';
        }else{
            $route = 'agent.allprescription';
        }
        return redirect()->route($route)->with('success','Report Added!');
    }

}
