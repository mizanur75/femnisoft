<?php

namespace App\Http\Controllers\Pharma;

use App\Http\Controllers\Controller;
use App\Model\Generic;
use App\Model\Medicine;
use App\Model\Patient;
use App\Model\Type;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $current_date = now()->format('d');
    	$last_date = \Carbon\Carbon::now()->daysInMonth;

    	// if ($last_date - $current_date == 5 || $last_date - $current_date == 4 || $last_date - $current_date == 3 || $last_date - $current_date == 2 || $last_date - $current_date == 1) {
    	// 	DB::table('users')->where('id', Auth::user()->id)->update(['payment' => 2]);
    	// }
    	$mostprescribed = DB::table('prices as pr')
                            ->join('prescriptions as pres','pr.id','=','pres.price_id')
                            ->join('medicines as med','med.id','=','pr.medicine_id')
                            ->join('types as tp','tp.id','=','pr.type_id')
                            ->join('measurements as mes','mes.id','=','pr.measurement_id')
                            ->join('generics as g','g.id','=','med.generic_id')
                            ->join('pharmas as ph','ph.id','=','med.company_id')
                            ->select('pr.*','g.name as gen','tp.name as cat','mes.measurement as mes','med.name as medname','ph.name as pharma', \DB::raw('SUM(pres.qty) as qty'))
                            ->groupBy('pres.price_id')
                            ->orderBy('qty','DESC')
                            ->limit(100)
                            ->get();
    	$medicines = Medicine::all();
    	$mymedicines = Medicine::where('user_id', Auth::user()->id)->get();
        $categories = Type::all();
        $generics = Generic::all();
        return view('pharma.index', compact('medicines','mymedicines','categories','generics','mostprescribed'));
    }
}
