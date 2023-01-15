<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Model\CostDetails;
use App\Model\CostMaster;
use App\Model\OrderDetails;
use App\Model\OrderMaster;
use App\Model\Stock;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

    	$current_date = now()->format('d');
    	$last_date = Carbon::now()->daysInMonth;

    	if ($last_date - $current_date == 5 || $last_date - $current_date == 4 || $last_date - $current_date == 3 || $last_date - $current_date == 2 || $last_date - $current_date == 1) {
    		DB::table('users')->where('id', Auth::user()->id)->update(['payment' => 2]);
    	}

    	$products = Stock::where('user_id', Auth::user()->id)->get();
    	$costinvoice = CostMaster::where('user_id', Auth::user()->id)->get();
    	$costs = CostDetails::where('user_id', Auth::user()->id)->get();
    	$invoices = OrderMaster::where('user_id', Auth::user()->id)->get();
        $reports = OrderDetails::where('user_id', Auth::user()->id)->get();
        $year = date('Y');

		$jan = $year.'-01';
		$feb = $year.'-02';
		$mar = $year.'-03';
		$apr = $year.'-04';
		$may = $year.'-05';
		$jun = $year.'-06';
		$jul = $year.'-07';
		$aug = $year.'-08';
		$sep = $year.'-09';
		$oct = $year.'-10';
		$nov = $year.'-11';
		$dec = $year.'-12';

// ==================== TP =========================
		$jan_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $jan .'%')->get();
		$jatp = 0;
		foreach($jan_tp as $tp){
			$jatp += $tp->tp * $tp->qty;
		}
		$feb_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $feb .'%')->get();
		$ftp = 0;
		foreach($feb_tp as $tp){
			$ftp += $tp->tp * $tp->qty;
		}
		$mar_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $mar .'%')->get();
		$mtp = 0;
		foreach($mar_tp as $tp){
			$mtp += $tp->tp * $tp->qty;
		}
		$apr_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $apr .'%')->get();
		$aptp = 0;
		foreach($apr_tp as $tp){
			$aptp += $tp->tp * $tp->qty;
		}
		$may_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $may .'%')->get();
		$matp = 0;
		foreach($may_tp as $tp){
			$matp += $tp->tp * $tp->qty;
		}
		$jun_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $jun .'%')->get();
		$jtp = 0;
		foreach($jun_tp as $tp){
			$jtp += $tp->tp * $tp->qty;
		}
		$jul_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $jul .'%')->get();
		$jutp = 0;
		foreach($jul_tp as $tp){
			$jutp += $tp->tp * $tp->qty;
		}
		$aug_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $aug .'%')->get();
		$autp = 0;
		foreach($aug_tp as $tp){
			$autp += $tp->tp * $tp->qty;
		}
		$sep_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $sep .'%')->get();
		$setp = 0;
		foreach($sep_tp as $tp){
			$setp += $tp->tp * $tp->qty;
		}
		$oct_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $oct .'%')->get();
		$octp = 0;
		foreach($oct_tp as $tp){
			$octp += $tp->tp * $tp->qty;
		}
		$nov_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $nov .'%')->get();
		$notp = 0;
		foreach($nov_tp as $tp){
			$notp += $tp->tp * $tp->qty;
		}
		$dec_tp = OrderDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $dec .'%')->get();
		$dtp = 0;
		foreach($dec_tp as $tp){
			$dtp += $tp->tp * $tp->qty;
		}

		
// ==================== Sales =========================
		$jan_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $jan .'%')->get();
		$jasales = 0;
		foreach($jan_sales as $sales){
			$jasales += $sales->total_amount;
		}
		$feb_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $feb .'%')->get();
		$fsales = 0;
		foreach($feb_sales as $sales){
			$fsales += $sales->total_amount;
		}
		$mar_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $mar .'%')->get();
		$msales = 0;
		foreach($mar_sales as $sales){
			$msales += $sales->total_amount;
		}
		$apr_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $apr .'%')->get();
		$apsales = 0;
		foreach($apr_sales as $sales){
			$apsales += $sales->total_amount;
		}
		$may_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $may .'%')->get();
		$masales = 0;
		foreach($may_sales as $sales){
			$masales += $sales->total_amount;
		}
		$jun_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $jun .'%')->get();
		$jsales = 0;
		foreach($jun_sales as $sales){
			$jsales += $sales->total_amount;
		}
		$jul_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $jul .'%')->get();
		$jusales = 0;
		foreach($jul_sales as $sales){
			$jusales += $sales->total_amount;
		}
		$aug_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $aug .'%')->get();
		$ausales = 0;
		foreach($aug_sales as $sales){
			$ausales += $sales->total_amount;
		}
		$sep_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $sep .'%')->get();
		$sesales = 0;
		foreach($sep_sales as $sales){
			$sesales += $sales->total_amount;
		}
		$oct_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $oct .'%')->get();
		$ocsales = 0;
		foreach($oct_sales as $sales){
			$ocsales += $sales->total_amount;
		}
		$nov_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $nov .'%')->get();
		$nosales = 0;
		foreach($nov_sales as $sales){
			$nosales += $sales->total_amount;
		}
		$dec_sales = OrderMaster::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $dec .'%')->get();
		$dsales = 0;
		foreach($dec_sales as $sales){
			$dsales += $sales->total_amount;
		}

// ==================== Cost =========================
		$jan_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $jan .'%')->get();
		$jacost = 0;
		foreach($jan_cost as $cost){
			$jacost += $cost->cost_price;
		}
		$feb_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $feb .'%')->get();
		$fcost = 0;
		foreach($feb_cost as $cost){
			$fcost += $cost->cost_price;
		}
		$mar_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $mar .'%')->get();
		$mcost = 0;
		foreach($mar_cost as $cost){
			$mcost += $cost->cost_price;
		}
		$apr_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $apr .'%')->get();
		$apcost = 0;
		foreach($apr_cost as $cost){
			$apcost += $cost->cost_price;
		}
		$may_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $may .'%')->get();
		$macost = 0;
		foreach($may_cost as $cost){
			$macost += $cost->cost_price;
		}
		$jun_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $jun .'%')->get();
		$jcost = 0;
		foreach($jun_cost as $cost){
			$jcost += $cost->cost_price;
		}
		$jul_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $jul .'%')->get();
		$jucost = 0;
		foreach($jul_cost as $cost){
			$jucost += $cost->cost_price;
		}
		$aug_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $aug .'%')->get();
		$aucost = 0;
		foreach($aug_cost as $cost){
			$aucost += $cost->cost_price;
		}
		$sep_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $sep .'%')->get();
		$secost = 0;
		foreach($sep_cost as $cost){
			$secost += $cost->cost_price;
		}
		$oct_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $oct .'%')->get();
		$occost = 0;
		foreach($oct_cost as $cost){
			$occost += $cost->cost_price;
		}
		$nov_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $nov .'%')->get();
		$nocost = 0;
		foreach($nov_cost as $cost){
			$nocost += $cost->cost_price;
		}
		$dec_cost = CostDetails::where('user_id', Auth::user()->id)->where('created_at', 'LIKE','%'. $dec .'%')->get();
		$dcost = 0;
		foreach($dec_cost as $cost){
			$dcost += $cost->cost_price;
		}
		// return $dcost;
    	return view('pharmacy.index', compact('products','reports','invoices','costs','costinvoice','current_date','last_date','jasales','fsales','msales','apsales','masales','jsales','jusales','ausales','sesales','ocsales','nosales','dsales','jatp','ftp','mtp','aptp','matp','jtp','jutp','autp','setp','octp','notp','dtp','jacost','fcost','mcost','apcost','macost','jcost','jucost','aucost','secost','occost','nocost','dcost'));
    }
}
