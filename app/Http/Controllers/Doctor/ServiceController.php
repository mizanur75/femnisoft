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
//            'category_id' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
            'description' => 'required',
            'photo' => 'required'
        ]);
        $slug = Str::slug($request->title);
        $image = $request->file('photo');
        $image2 = $request->file('image2');

        if (isset($image)){
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!file_exists('assets/images/services')){
                mkdir('assets/images/services', true, 777);
            }
            $image->move('assets/images/services',$imagename);
        }else{
            $imagename = '';
        }

        if(isset($image2)){
            $image2name = $slug.'-'.uniqId().'.'.$image2->getClientOriginalExtension();
            if (!file_exists('assets/images/image2')){
                mkdir('assets/images/image2', true, 777);
            }
            $image2->move('assets/images/image2',$image2name);
        }else{
            $image2name = 'default.png';
        }

        $service = new Service();
        $service->user_id = Auth::user()->id;
        $service->category_id = $request->category_id;
        $service->title = $request->title;
        $service->sub_title = $request->sub_title;
        $service->slug = $slug;
        $service->description = $request->description;
        $service->details = $request->details;
        $service->photo = $imagename;
        $service->image2 = $image2name;
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
//            'category_id' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
            'description' => 'required'
        ]);
        $slug = Str::slug($request->title);
        $service = Service::findOrFail($id);
        $image = $request->file('photo');

        $image2 = $request->file('image2');
        if (isset($image)){
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (file_exists('assets/images/services/'.$service->photo)){
                unlink('assets/images/services/'.$service->photo);
            }
            if (!file_exists('assets/images/services')){
                mkdir('assets/images/services', true, 777);
            }
            $image->move('assets/images/services',$imagename);
        }else{
            $imagename = $service->photo;
        }

        if(isset($image2)){
            $image2name = $slug.'-'.uniqId().'.'.$image2->getClientOriginalExtension();
            if (file_exists('assets/images/image2/'.$service->photo)){
                unlink('assets/images/image2/'.$service->photo);
            }
            if (!file_exists('assets/images/image2')){
                mkdir('assets/images/image2', true, 777);
            }
            $image2->move('assets/images/image2',$image2name);
        }else{
            $image2name = $service->image2;
        }

        $service->user_id = Auth::user()->id;
        $service->category_id = $request->category_id;
        $service->title = $request->title;
        $service->sub_title = $request->sub_title;
        $service->slug = $slug;
        $service->description = $request->description;
        $service->details = $request->details;
        $service->photo = $imagename;
        $service->image2 = $image2name;
        $service->status = $request->status;
        $service->save();

        return redirect()->route('doctor.web-service.index')->with('success','Service Successfully Updated!');
    }

    public function destroy($id)
    {
        //
    }
}
