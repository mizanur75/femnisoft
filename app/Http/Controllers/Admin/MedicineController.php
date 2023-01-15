<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Generic;
use App\Model\Type;
use App\Model\Medicine;

class MedicineController extends Controller
{

    public function index()
    {
        $medicines = DB::table('medicines as med')
                        ->join('types as ty','ty.id','=','med.type_id')
                        ->join('generics as gen','gen.id','=','med.generic_id')
                        ->select('med.*','gen.name as generic','ty.name as type')
                        ->get();
        return view('admin.medicine.all', compact('medicines'));
    }

    public function create()
    {
        $generics = Generic::all();
        $types = Type::all();
        return view('admin.medicine.add', compact('types','generics'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'type_id' => 'required',
            'generic_id' => 'required',
            'name' => 'required',
            'company' => 'required',
        ]);
        $medicine = new Medicine();
        $medicine->type_id = $request->type_id;
        $medicine->generic_id = $request->generic_id;
        $medicine->name = $request->name;
        $medicine->brand_name = $request->brand_name;
        $medicine->slug = str_slug($request->name);
        $medicine->description = $request->description;
        $medicine->disease = $request->disease;
        $medicine->side_effect = $request->side_effect;
        $medicine->company = $request->company;
        $medicine->doses = $request->doses;
        $medicine->status = $request->status;
        $medicine->save();

        return redirect()->route('admin.medicine.index')->with('success','Successfully Added!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $medicine = Medicine::find($id);
        $generics = Generic::all();
        $types = Type::all();
        return view('admin.medicine.edit', compact('types','generics','medicine'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'type_id' => 'required',
            'generic_id' => 'required',
            'name' => 'required',
            'company' => 'required',
        ]);
        $medicine = Medicine::find($id);
        $medicine->type_id = $request->type_id;
        $medicine->generic_id = $request->generic_id;
        $medicine->name = $request->name;
        $medicine->brand_name = $request->brand_name;
        $medicine->slug = str_slug($request->name);
        $medicine->description = $request->description;
        $medicine->disease = $request->disease;
        $medicine->side_effect = $request->side_effect;
        $medicine->company = $request->company;
        $medicine->doses = $request->doses;
        $medicine->status = $request->status;
        $medicine->save();

        return redirect()->route('admin.medicine.index')->with('success','Successfully Updated!');
    }

    public function destroy($id)
    {
        $medicine = Medicine::find($id);
        $medicine->delete();
        return back()->with('success','Successfully Deleted!');;
    }
}
