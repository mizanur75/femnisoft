<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="refresh" content="60"/>
	<title>Today's Appointment</title>

	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/fontawesome.min.css"/> --}}
	<!-- Fav  Icon Link -->
	<link rel="shortcut icon" type="image/png" href="{{asset('assets/images/short-icon.jpg')}}">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
	<!-- Main CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/green.css')}}" id="style_theme">
	<link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
	<!-- morris charts -->

	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/mystyle.css')}}">
	<style>

	select.form-control:not([size]):not([multiple]) {
	    height: 1.8rem;
	    width: 3rem;
	}
	</style>

</head>

<body>
	<!-- <div class="loading">
		<div class="spinner">
			<div class="double-bounce1"></div>
			<div class="double-bounce2"></div>
		</div>
	</div> -->
	<!--/Pre Loader -->
	<div class="wrapper">
		<!-- Page Content -->
		<div id="content">
			<div class="container top-brand">
			    <nav class="navbar navbar-default">			
			        <div class="navbar-header">
			            <div class="sidebar-header"><img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="height: 75px;">
			            	<h2 class="color-green font-weight-bold" style="letter-spacing: 0px; float: right; margin-top: 5px; margin-left: 15px; font-size: 52px;">এখলাসপুর সেন্টার অফ হেলথ</h2>
			            </div>
			        </div>
			            <div class="float-right"><h2 class="font-weight-bold" style="color: red;">{{date('d M Y')}}</h2></div>
			    </nav>
			</div>
			<!-- Top Navigation -->
			<!-- Menu -->
			<div class="container menu-nav">
			    <nav class="navbar navbar-expand-lg proclinic-bg text-white">
			        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
			            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			            <span class="ti-menu text-white"></span>
			        </button>

			        <div class="collapse navbar-collapse" id="navbarSupportedContent">
			            <ul class="navbar-nav mr-auto">
			            </ul>
			        </div>
			    </nav>
			</div>
			<!-- Breadcrumb -->

			<div class="container mt-0">
				<div class="row breadcrumb-bar">
					<div class="col-md-6">
					</div>
					<div class="col-md-6">
						<ol class="breadcrumb">
						</ol>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			<!-- Main Content -->
			<div class="container home" style="min-height: 400px;">
				<div class="row">
					<!-- Widget Item -->
					<div class="col-md-12">
						<div class="widget-area-2 proclinic-box-shadow">
							<div class="table-responsive">
								<table id="tableId" class="table table-sm table-bordered table-striped">
									<thead>
										<tr class="text-center">
											
											<th>#SL</th>
											@if($title == "Today's")
											<th>Today's SL</th>
											@endif
											<th>ECOH ID</th>
											<th>Patient Type</th>
											<th>Dr. Name</th>
											<th>Patient Name</th>
											<th>Age</th>
											<th>Address</th>
											<th>Visit</th>
										</tr>
									</thead>
									<tbody>
										@php($current_date = date('y-m-d', strtotime(now())))
										@foreach($appoints as $appoint)
										@php($histor = \App\Model\History::where('status',0)->where('doctor_id',$appoint->did)->where('patient_id',$appoint->pid)->first())
										<tr>
											
											<!-- <td class="text-center">{{$appoint->pid}}</td> -->
											
											<td class="text-center">{{$loop->index +1}}</td>
											@if($title == "Today's")
											<td class="text-center">
												@if($appoint->serial_no)
												{{$appoint->serial_no}}
												@else
												<span class="color-red">NAY</span>
												@endif
											</td>
											@endif
											<td class="text-center">{{$appoint->ecohid}}</td>
											<td class="text-center">{{$appoint->patient_type}}</td>
											<td>{{$appoint->dname}}</td>
											<td>{{$appoint->name}}</td>
											<td class="text-center">
												@php($age = \Carbon\Carbon::parse($appoint->age)->diff(\Carbon\Carbon::now())->format('%y'))
												{{$age}}
											</td>
											<td class="text-center">{{$appoint->address}}</td>
											<td class="text-center">
												@php($countcheck = \App\Model\PatientRequest::where('status',1)->where('patient_id',$appoint->pid)->count())
												@if($countcheck > 0)
												    <button type="button" class="btn btn-padding btn-sm btn-outline-info"> {{$countcheck}}</button>
												    @else
												    <button type="button" class="btn btn-padding btn-sm btn-outline-success">New</button>
												@endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- /Widget Item -->
				</div>
			</div>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="widget-area-2 proclinic-box-shadow pb-3 text-center pt-3">
						  <span class="text-center">Copyright <strong>©</strong>2020-{{date('Y')}} | Developed by <a href="http://www.devmizanur.com/" class="font-weight-bold" target="_blank">www.devmizanur.com</a></span>
					</div>
				</div>
			</div>
		</div>
		<!-- /Copy Rights-->
	</div>
	<!-- /Page Content -->
</div>
<!-- Back to Top -->
<a id="back-to-top" href="#" class="back-to-top">
	<span class="ti-angle-up"></span>
</a>

<script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$("#tableId").dataTable({
		pageLength : 50,
	    lengthMenu: [[50, 10, 20, 100, 500], [50, 10, 20, 100, 500]]
	});
</script>
</body>

</html>