<?php

namespace App\Http\Controllers;

use App\Model\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class DatatableController extends Controller
{
    public function all_patient(Request $request){
        $patients = DB::table('patients')->orderBy('id','DESC');
        return DataTables::queryBuilder($patients)->toJson();
    }
}
