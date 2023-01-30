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

 Route::group(['middleware' => ['api']], function () {
     Route::get('services', 'Api\FrontController@services')->name('services');
     Route::get('front-services', 'Api\FrontController@frontservices')->name('frontservices');
     Route::get('services-details/{id}', 'Api\FrontController@servicesdetails')->name('servicesdetails');
     Route::get('blogs', 'Api\FrontController@blog')->name('blog');
     Route::get('blog/{id}', 'Api\FrontController@blogdetails')->name('blogdetails');
     Route::get('front-blog', 'Api\FrontController@frontblog')->name('frontblog');
     Route::get('testimonial', 'Api\FrontController@testimonial')->name('testimonial');
     Route::post('set-appoint', 'Api\FrontController@set_appoint')->name('set_appoint');
 });

