<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{

    public function index()
    {
        $pharmacies = Pharmacy::all();
        return view('admin.pharmacy.all', compact('pharmacies'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
