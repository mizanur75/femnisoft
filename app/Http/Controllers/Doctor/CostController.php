<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Model\CostMaster;
use App\Model\CostName;
use App\Model\Expend;
use App\Traits\ExpendTrait;
use Auth;
use DB;
use Illuminate\Http\Request;

class CostController extends Controller
{
    use ExpendTrait;
    public function index()
    {

        $start = '';
        $finish = '';
        $cost_name_id = '';
        $costs = DB::table('expends as ex')
                    ->join('cost_names as cn','cn.id','=','ex.cost_name_id')
                    ->orderBy('id','DESC')
                    ->select('ex.*','cn.cost_name as cost_name')
                    ->get();
        $costname = CostName::all();
        return view('view.cost.all', compact('costname','costs','cost_name_id','start','finish'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $this->addExpend($request);

        return back()->with('success','Success!');
    }

    public function show($id)
    {
        $data = Expend::find($id);
        return response($data);
    }

    public function edit($id)
    {
        $costname = CostName::find($id);
        return response()->json($costname);
    }

    public function update(Request $request, $id)
    {
        $this->editExpend($request, $id);
        return back()->with('success','Update Success!');
    }

    public function destroy($id)
    {
        //
    }
    public function costlist()
    {
        $costs = [];
        return view('view.cost.all', compact('costs'));
    }

    public function expeddituresearch(Request $request){
        $cost_name_id = $request->cost_name_id;
        $costname = CostName::all();
        if ($request->start == null) {
            $start = '';
        }else{
            $start = date('Y-m-d', strtotime($request->start))." 00:00:00";
        }
        if ($request->finish == null) {
            $finish = '';
        }else{
            $finish = date('Y-m-d', strtotime($request->finish))." 23:59:59";
        }
        if ($cost_name_id == null) {
            $costs = Expend::orderBy('id','DESC')
                        ->whereBetween('date', [$start, $finish])
                        ->get();
            return view('view.cost.all', compact('costname','costs','cost_name_id','start','finish'));
        }
        if ($start == null && $finish == null) {
            $costs = Expend::orderBy('id','DESC')
                        ->where('cost_name_id',$cost_name_id)
                        ->get();
            return view('view.cost.all', compact('costname','costs','cost_name_id','start','finish'));
        }
        if ($start == !null && $finish == !null && $cost_name_id == !null) {
            $costs = Expend::orderBy('id','DESC')
                        ->where('cost_name_id',$cost_name_id)
                        ->whereBetween('date', [$start, $finish])
                        ->get();
            return view('view.cost.all', compact('costname','costs','cost_name_id','start','finish'));
        }

        $costs = Expend::orderBy('id','DESC')
                    ->whereBetween('date', [$start, $finish])
                    ->get();
        return view('view.cost.all', compact('costname','costs','cost_name_id','start','finish'));
    }
}
