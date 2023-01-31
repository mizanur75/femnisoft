<?php

namespace App\Http\Controllers\Doctor;

use App\Model\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Review::orderBy('id','DESC')->get();
        return view('view.testimonial.all', compact('testimonials'));
    }

    public function create()
    {
        return view('view.testimonial.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'photo' => 'required'
        ]);
        $slug = Str::slug($request->name);
        $image = $request->file('photo');

        if (isset($image)){
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!file_exists('assets/images/testimonials')){
                mkdir('assets/images/testimonials', true, 777);
            }
            $image->move('assets/images/testimonials',$imagename);
        }else{
            $imagename = '';
        }

        $testimonial = new Review();
        $testimonial->title = $request->name;
        $testimonial->details = $request->description;
        $testimonial->photo = $imagename;
        $testimonial->status = $request->status;
        $testimonial->save();

        return redirect()->route('doctor.web-testimonial.index')->with('success','Review Successfully created!');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $testimonial = Review::findOrFail($id);
        return view('view.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);
        $slug = Str::slug($request->name);
        $testimonial = Review::findOrFail($id);
        $image = $request->file('photo');
        if (isset($image)){
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (file_exists('assets/images/testimonials/'.$testimonial->photo)){
                if ($testimonial->photo){

                    unlink('assets/images/testimonials/'.$testimonial->photo);
                }
            }
            if (!file_exists('assets/images/testimonials')){
                mkdir('assets/images/testimonials', true, 777);
            }
            $image->move('assets/images/testimonials',$imagename);
        }else{
            $imagename = $testimonial->photo;
        }
        $testimonial->title = $request->name;
        $testimonial->details = $request->description;
        $testimonial->photo = $imagename;
        $testimonial->status = $request->status;
        $testimonial->save();

        return redirect()->route('doctor.web-testimonial.index')->with('success','Review Successfully Updated!');
    }
    public function destroy($id)
    {
        //
    }
}
