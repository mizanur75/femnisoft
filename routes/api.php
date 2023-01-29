<?php

// use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

 Route::group(['middleware' => ['api','cors']], function () {
     Route::get('/services', 'Api\FrontController@services')->name('services');
     Route::get('/front-services', 'Api\FrontController@frontservices')->name('frontservices');
     Route::get('/blog', 'Api\FrontController@blog')->name('blog');
     Route::get('/front-blog', 'Api\FrontController@frontblog')->name('frontblog');

 });

