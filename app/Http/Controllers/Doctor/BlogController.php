<?php

namespace App\Http\Controllers\Doctor;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('id','DESC')->get();
        return view('view.blog.all', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('view.blog.add', compact('categories'));
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
            if (!file_exists('assets/images/blogs')){
                mkdir('assets/images/blogs', true, 777);
            }
            $image->move('assets/images/blogs',$imagename);
        }else{
            $imagename = '';
        }

        $blog = new Blog();
        $blog->user_id = Auth::user()->id;
        $blog->category_id = $request->category_id;
        $blog->title = $request->title;
        $blog->slug = $slug;
        $blog->description = $request->description;
        $blog->photo = $imagename;
        $blog->status = $request->status;
        $blog->save();

        return redirect()->route('doctor.web-blog.index')->with('success','Blog Successfully created!');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = Category::get();
        return view('view.blog.edit', compact('blog','categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);
        $slug = Str::slug($request->title);
        $blog = Blog::findOrFail($id);
        $image = $request->file('photo');
        if (isset($image)){
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (file_exists('assets/images/blogs/'.$blog->photo)){
                if ($blog->photo){

                    unlink('assets/images/blogs/'.$blog->photo);
                }
            }
            if (!file_exists('assets/images/blogs')){
                mkdir('assets/images/blogs', true, 777);
            }
            $image->move('assets/images/blogs',$imagename);
        }else{
            $imagename = $blog->photo;
        }
        $blog->user_id = Auth::user()->id;
        $blog->category_id = $request->category_id;
        $blog->title = $request->title;
        $blog->slug = $slug;
        $blog->description = $request->description;
        $blog->photo = $imagename;
        $blog->status = $request->status;
        $blog->save();

        return redirect()->route('doctor.web-blog.index')->with('success','Blog Successfully Updated!');
    }

    public function destroy($id)
    {
        //
    }
}
