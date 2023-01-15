<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Doctor;
use App\Model\Generic;
use App\Model\History;
use App\Model\Medicine;
use App\Model\Patient;
use App\Model\PatientRequest;
use App\Model\Pharmacy;
use App\Model\Prescription;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $patients = Patient::all();
        $appoints = PatientRequest::all();
        $pharmacies = Pharmacy::all();
        $prescriptions = History::all();
        $medicines = Medicine::all();
        $doctors = Doctor::all();
        $generics = Generic::all();
        $users = User::all();
        return view('admin.index', compact('patients','appoints','pharmacies','prescriptions','medicines','doctors','generics','users'));
    }
}
