<?php

Route::get('/', 'Front\FrontController@index');
Route::get('/about', 'Front\FrontController@about')->name('about');
Route::get('/team', 'Front\FrontController@team')->name('team');
Route::get('/services', 'Front\FrontController@services')->name('services');
Route::get('/blog', 'Front\FrontController@blog')->name('blog');
Route::get('/faq', 'Front\FrontController@faq')->name('faq');
Route::get('/pdf', 'Front\FrontController@pdf');
Route::post('/newsletter', 'Front\FrontController@newsletter')->name('newsletter');
Route::post('/message', 'Front\FrontController@message')->name('message');
Route::post('/set-appoint', 'Front\FrontController@set_appoint')->name('set_appoint');

Auth::routes(['register' => false]);

Route::get('/optimize', 'HomeController@optimize_clear')->name('optimize');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/go-to-pay', 'HomeController@pay')->name('gopay');
Route::post('/select-pre-history', 'PageController@pre_history')->name('pre_history');
Route::get('today-display-appoint', 'PageController@display_appoint')->name('display_appoint')->middleware('auth');
Route::get('get-report-for-export/{history_id}', 'PageController@getReportForExport')->name('getReportForExport')->middleware('auth');
Route::put('report-for-follow-up-export-update', 'PageController@reportForFollowUpExportUpdate')->name('reportForFollowUpExportUpdate')->middleware('auth');

// SSLCOMMERZ Start
Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
Route::get('/example2', 'SslCommerzPaymentController@exampleHostedCheckout');

Route::post('/pay', 'SslCommerzPaymentController@index')->name('pay');
Route::post('/pay-via-ajax', 'SslCommerzPaymentController@payViaAjax');

Route::post('/success', 'SslCommerzPaymentController@success');
Route::post('/fail', 'SslCommerzPaymentController@fail');
Route::post('/cancel', 'SslCommerzPaymentController@cancel');

Route::post('/ipn', 'SslCommerzPaymentController@ipn');
//SSLCOMMERZ END

// DataTables
Route::get('all_patient','DatatableController@all_patient')->name('all_patient');

//  ====================== Admi Route 1  =====================
Route::group(['as'=>'admin.','prefix' => 'admin','namespace'=>'Admin','middleware'=>['auth','admin']], function () {
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::resource('user','UserController');
    Route::resource('patient','PatientController');
    Route::resource('test','TestController');
    Route::resource('type','TypeController');
    Route::resource('generic','GenericController');
    Route::resource('medicine','MedicineController');

    Route::resource('pharmacy','PharmacyController');

    Route::get('doctors','DoctorController@index')->name('doctors');
    Route::resource('chamber','ChamberController');
    Route::get('doctor-details/{id}','DoctorController@doctorshow')->name('doctorshow');
    Route::get('user-permission','UserController@permission')->name('permission');
    Route::put('user-changepermission/{id}','UserController@changepermission')->name('changepermission');
    Route::put('user-status/{id}','UserController@status')->name('status');
    Route::get('payment-set/{id}','UserController@payment_set')->name('paymentset');
    Route::get('all-payment','UserController@allpayment')->name('allpayment');
    Route::get('user-payment/{id}','UserController@userpayment')->name('userpayment');
    Route::get('appoint-payment','PaymentController@index')->name('apptindex');
    Route::get('appoint-payment-all','PaymentController@payment_all')->name('payment_all');
    Route::post('appoint-make-payment','PaymentController@store_payment')->name('storepayment');
    Route::get('appoint-received-payment/{id}','PaymentController@received_payment')->name('receivedpayment');

});

//  ============== Agent/Assistant Route 2 =================

Route::group(['as'=>'agent.','prefix' => 'agent','namespace'=>'Agent','middleware'=>['auth','agent']], function () {
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    
});

//  ================= Doctor Route 3  ===================

Route::group(['as'=>'doctor.','prefix' => 'doctor','namespace'=>'Doctor','middleware'=>['auth','doctor']], function () {
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::get('doctors','DashboardController@doctors')->name('doctors');
    Route::get('doctor-details/{id}','DashboardController@doctorshow')->name('doctorshow');
    Route::get('password-change','ProfileController@password_change')->name('password_change');
    Route::post('password-changed','ProfileController@password_changed')->name('password_changed');
    Route::post('call-to-agent','AppointController@call_to_agent')->name('calltoagent');
    Route::resource('profile','ProfileController');
    Route::post('status','ProfileController@status')->name('status');
    Route::resource('patient','PatientController');
    Route::post('address-load','PatientController@loadAddress')->name('loadAddress');
    Route::get('patient-exist-or-not/{id}','PatientController@patient_exist')->name('patient_exist');
    Route::get('patient-search','PatientController@patient_search')->name('patient_search');
    Route::post('patient-barcode-details','PatientController@barcode_details')->name('barcode_details');
    Route::post('check-ecoh-id','PatientController@check_ecoh_id')->name('check_ecoh_id');
    Route::resource('patient-info','PatientinfoController');
    Route::get('patient-prescribed','PatientController@mypatient')->name('mypatient');
    Route::resource('appoint','AppointController');
    Route::get('get-appoint-online','AppointController@get_appoint')->name('get_appoint');
    Route::get('accept-appoint-online/{id}','AppointController@accept')->name('accept');
    Route::get('declined-appoint-online/{id}','AppointController@declined')->name('declined');
    Route::get('appoint-today/{today}','AppointController@appoint_today')->name('appoint_today');
    Route::get('appoint-today-all/{today}','AppointController@all_appoint_today')->name('all_appoint_today');
    Route::get('appoint-by-doctor/{id}','AppointController@appoint_by_doctor')->name('appoint_by_doctor');
    Route::get('delete-appoint/{id}','AppointController@deleteappoint')->name('deleteappoint');

    Route::get('appoint/patient/report/{id}','AppointController@reports')->name('reports');
    Route::get('appoint/patient/report/edit/{id}','AppointController@edit_reports')->name('edit_reports');
    Route::get('appoint/patient/report/add/{id}','AppointController@add_reports')->name('add_reports');
    Route::post('appoint/patient/report/added','AppointController@reports_added')->name('reports_added');
    Route::put('appoint/patient/report/update/{id}','AppointController@update_reports')->name('update_reports');
    Route::post('delete-report-on-edit','AppointController@delete_report')->name('delete_report');
    Route::post('select-test','AppointController@selectTest')->name('selectTest');

    Route::get('appoint-by-date','AppointController@appoint_by_doctor_date')->name('appoint_by_doctor_date');
    Route::resource('prescription','PrescriptionController');
    Route::get('prescription-edit/{id}','PrescriptionController@edit_prescription')->name('edit_prescription');
    Route::get('prescription-all','PrescriptionController@allprescription')->name('allprescription');
    Route::get('prescription-search','PrescriptionController@search_prescription')->name('search_prescription');
    Route::get('prescription-today/{today}','PrescriptionController@today')->name('todayPrescrition');
    Route::post('/prescription-by-date-doctor', 'PrescriptionController@pres_show_by_dr_date')->name('pres_show_by_dr_date');
    Route::get('go-appoint-pay-request/{doctor_id}/{patient_id}','PatientinfoController@payrequest')->name('payrequest');
    Route::get('doctor-write-prescription/{doctor_id}/{patient_id}','PatientinfoController@sendrequest')->name('sendrequest');
    Route::post('select',['uses'=>'PrescriptionController@select'])->name('select');
    Route::get('onload-medicine','PrescriptionController@onload_medicine')->name('onload_medicine');
    Route::post('live-search',['uses'=>'PrescriptionController@live_search'])->name('live_search');
    Route::post('meddetails',['uses'=>'PrescriptionController@meddetails'])->name('meddetails');
    Route::post('pre-meddetails',['uses'=>'PrescriptionController@pre_meddetails'])->name('pre_meddetails');

    Route::resource('address','AddressController');


    Route::resource('advice','AdviceController');
    Route::resource('frequency','FrequencyController');
    Route::resource('qty','QtyController');
    Route::resource('qtytype','QtytypeController');
    Route::resource('eatingtime','EatingtimeController');

    //================== Cost ==================================
    Route::resource('blog','BlogController');

    //------------ ADMIN SLIDER SECTION ------------

    Route::get('/slider/datatables', 'SliderController@datatables')->name('doctor-sl-datatables'); //JSON REQUEST
    Route::get('/slider', 'SliderController@index')->name('doctor-sl-index');
    Route::get('/slider/create', 'SliderController@create')->name('doctor-sl-create');
    Route::post('/slider/create', 'SliderController@store')->name('doctor-sl-store');
    Route::get('/slider/edit/{id}', 'SliderController@edit')->name('doctor-sl-edit');
    Route::post('/slider/edit/{id}', 'SliderController@update')->name('doctor-sl-update');  
    Route::get('/slider/delete/{id}', 'SliderController@destroy')->name('doctor-sl-delete');
    //------------ ADMIN SLIDER SECTION ENDS ------------
});

//  =========================== Pharmacy Route 4 ============================

Route::group(['as' => 'pharmacy.','prefix' => 'pharmacy','namespace' => 'Pharmacy', 'middleware' => ['auth','pharmacy']], function(){
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    
});

//  =========================== Pharmaceuticals Route 5 ============================

Route::group(['as' => 'pharma.','prefix' => 'pharma','namespace' => 'Pharma', 'middleware' => ['auth','pharma']], function(){
    Route::get('dashboard','DashboardController@index')->name('dashboard');
});

//  =========================== User Route 6 ============================

Route::group(['as' => 'user.','prefix' => 'user','namespace' => 'User', 'middleware' => ['auth','user']], function(){
    Route::get('dashboard','DashboardController@index')->name('dashboard');
});

//  =========================== When Not Match Any Route ============================

Route::any('{query}','Front\FrontController@index')
  ->where('query', '.*');
