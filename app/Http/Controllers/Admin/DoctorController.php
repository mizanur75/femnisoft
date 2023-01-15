<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
class DoctorController extends Controller
{
    public function index(){
        $doctors = User::where('role_id',3)->get();
        return view('admin.doctor.all', compact('doctors'));
    }

    public function doctorshow($id){
    	$doctor = DB::table('doctors as d')
                        ->join('users as u','u.id','=','d.user_id')
                        ->where('d.user_id',$id)
                        ->select('d.*','u.name as name','u.email as email','u.phone as phone','u.gender as gender')
                        ->first();

        return response()->json($doctor);
    }

}
