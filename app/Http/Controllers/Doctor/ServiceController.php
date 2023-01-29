<?php

namespace App\Http\Controllers\Doctor;

use App\Model\Category;
use App\Model\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ServiceController extends Controller
{

    public function index()
    {
        $services = Service::orderBy('id','DESC')->get();
        return view('view.service.all', compact('services'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('view.service.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required'
        ]);
        $slug = Str::slug($request->title);
        $image = $request->file('photo');

        if (isset($image)){
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!file_exists('images/service')){
                mkdir('images/service', true, 777);
            }
            $image->move('images/service',$imagename);
        }else{
            $imagename = '';
        }

        $service = new Service();
        $service->user_id = Auth::user()->id;
        $service->category_id = $request->category_id;
        $service->title = $request->title;
        $service->slug = $slug;
        $service->description = $request->description;
        $service->photo = $imagename;
        $service->status = $request->status;
        $service->save();

        return redirect()->route('doctor.web-service.index')->with('success','Service Successfully created!');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $categories = Category::get();
        return view('view.service.edit', compact('service','categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);
        $slug = Str::slug($request->title);
        $service = Service::findOrFail($id);
        $image = $request->file('photo');
        if (isset($image)){
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (file_exists('images/service/'.$service->photo)){
                unlink('images/service/'.$service->photo);
            }
            if (!file_exists('images/service')){
                mkdir('images/service', true, 777);
            }
            $image->move('images/service',$imagename);
        }else{
            $imagename = $service->photo;
        }
        $service->user_id = Auth::user()->id;
        $service->category_id = $request->category_id;
        $service->title = $request->title;
        $service->slug = $slug;
        $service->description = $request->description;
        $service->photo = $imagename;
        $service->status = $request->status;
        $service->save();

        return redirect()->route('doctor.web-service.index')->with('success','Service Successfully Updated!');
    }

    public function destroy($id)
    {
        //
    }
}
