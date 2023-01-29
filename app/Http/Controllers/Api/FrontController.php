<?php

namespace App\Http\Controllers\Api;

use App\Model\Blog;
use App\Model\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{

    public function services(){
        $services = Service::orderBy('id','DESC')->take(5)->get();
        return response()->json($services)->header("Access-Control-Allow-Origin",  "*");
    }
    public function frontservices(){
        $services = Service::orderBy('id','DESC')->take(4)->get();
        return response()->json($services)->header("Access-Control-Allow-Origin",  "*");
    }
    public function blog(){
        $blog = Blog::orderBy('id','DESC')->take(16)->get();
        return response()->json($blog)->header("Access-Control-Allow-Origin",  "*");
    }
    public function frontblog(){
        $blog = Blog::orderBy('id','DESC')->take(2)->get();
        return response()->json($blog)->header("Access-Control-Allow-Origin",  "*");
    }
}
