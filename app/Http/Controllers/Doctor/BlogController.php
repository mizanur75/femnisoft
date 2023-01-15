<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use Auth;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('id','DESC')->get();
        return view('view.front.blog.all', compact('blogs'));
    }

    public function create()
    {
        return view('view.front.blog.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $blog = new Blog();
        $blog->user_id = Auth::user()->id;
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->status = $request->status;
        $blog->save();

        return redirect()->route('doctor.blog.index')->with('success','Blog Successfully created!');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('view.front.blog.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $blog = Blog::find($id);
        $blog->user_id = Auth::user()->id;
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->status = $request->status;
        $blog->save();

        return redirect()->route('doctor.blog.index')->with('success','Blog Successfully Updated!');
    }

    public function destroy($id)
    {
        //
    }
}
