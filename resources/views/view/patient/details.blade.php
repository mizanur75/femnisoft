@extends('layouts.app')
@section('title','Details of '.$patient->name)

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
<style>
select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
.form-control {
    border-color: #064619;
}
.select2-hidden-accessible {
    border: 0 !important;
    clip: rect(0 0 0 0) !important;
    -webkit-clip-path: inset(50%) !important;
    clip-path: inset(50%) !important;
    height: 1px !important;
    overflow: hidden !important;
    padding: 0 !important;
    position: absolute !important;
    width: 1px !important;
    white-space: nowrap !important;
}
.select2-container--bootstrap4 .select2-selection {
    border: 1px solid #646667;
    border-radius: .25rem;
    width: 100%;
}
.swal2-cancel{
	margin-right: 40px !important;
}
.swal2-popup .swal2-modal .swal2-show{
	width: 26% !important;
}
.card-image{
	height: 106px;
	width: 106px;
	border-radius: 2px;
	margin-top: -28px;
}
.card-ecoh{
	 font-size: 20px;
	 padding-top: 5px;
	 font-weight: 600;
}
.card-maintenance{
	font-size: 10px;
	width: 40%;
}
.card-develop{
	font-size: 10px;
}
/*.watermark{
	background-image: url({{asset("assets/images/logo-dark.png")}});
	width: 100%;
	background-repeat: no-repeat;
}*/
/*.watermark::after {
  content: 'IMAGE CAPTION';
  position: absolute;
  bottom: 0;
  left: 0;
  box-sizing: border-box;
  width: 100%;
  padding: 10px;
  color: white;
  font-size: 1.5em;
  background: rgba(0, 0, 0, 0.5);
}*/
</style>

@endpush


@section('content')
@php
$auth = Auth::user()->role->name;
$store = $auth == 'Doctor' ? route('doctor.patient-info.store') : route('agent.patient-info.store');
@endphp
<div class="row">
	<div class="col-md-12">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endif
		@if($errors->any())
			@foreach($errors->all() as $error)
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<strong>Opps!</strong> {{$error}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			@endforeach
		@endif
	</div>
</div>
<div class="row">
@if($auth == 'Agent')	
	@if(\App\Model\PatientInfo::where('patient_id',$patient->id)->count()>0)
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right">
            <a href="{{ route('agent.seedoctor',\Crypt::encrypt($patient->id)) }}" onclick="event.preventDefault(); seedoctor()" class="btn btn-padding btn-sm btn-info" id="seedoctor"><i class="fa fa-eye"></i> See Doctor</a>
        </div>
    </div>
    @endif
@else
	@php($doctor = \App\Model\Doctor::where('user_id',Auth::user()->id)->first())
	@if(\App\Model\PatientRequest::where('patient_id',$patient->id)->where('doctor_id',$doctor->id)->where('status',0)->where('is_delete',0)->count() == 0)
		<div class="col-md-12">
	        <div class="widget-area-2 proclinic-box-shadow text-right">
	            <a href="{{ route('doctor.payrequest',['doctor_id'=>$doctor->id, 'patient_id'=>$patient->id]) }}" onclick="return confirm('Are you sure?')" class="btn btn-padding btn-sm btn-info"><i class="fas fa-pencil-alt"></i> Write Advice </a>
	        </div>
	    </div>
    @endif
@endif
	<!-- Patient Details -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Client Details <a href="{{$auth == 'Agent' ? route('agent.patient.edit', \Crypt::encrypt($patient->id)) : route('doctor.patient.edit',$patient->id)}}" class="btn btn-padding btn-sm btn-info"> <i class="fa fa-edit"></i> </a></h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td style="width: 22%;">
								<img style="height: 245px; width: 245px; border-radius: 4px;" src="{{$patient->image == !null ? asset('images/patient/'.$patient->image) : asset('images/patient/default.png')}}">
							</td>
							<td>
								<table class="table table-bordered table-striped">
									<tbody>
										<tr>
											<td><strong>Client ID</strong></td>
											<td>{{$patient->centre_patient_id}}</td>
										</tr>
										<tr>
											<td><strong>Name</strong></td>
											<td>{{$patient->name}}</td>
										</tr>
										<tr>
											<td><strong>Age</strong> </td>
											@php($dob = strlen($patient->age) < 5 ? now() : $patient->age)
											@php($age = \Carbon\Carbon::parse($dob)->diff(\Carbon\Carbon::now())->format('%y'))
											<td>{{$age}}</td>
										</tr>
										<tr>
											<td><strong>Gender</strong></td>
											<td>
												{{$patient->gender == 0 ? 'Male':'Female'}}
											</td>
										</tr>
										<tr>
											<td><strong>Phone </strong></td>
											<td>{{$patient->phone}}</td>
										</tr>
										<tr>
											<td><strong>Address</strong></td>
											<td>{{$patient->address->name}}</td>
										</tr>
										<tr>
											<td><strong>Blood Group</strong></td>
											<td>{{$patient->blood_group}}</td>
				                        </tr>
										<tr>
											<td><strong>Marital Status</strong></td>
											<td>
												{{$patient->marital_status == 0 ? 'Single':'Married'}}
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- Appoint History -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Appoint History</h3>
			<div class="table-responsive">
				<table id="appoint_history" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Date</th>
							<!-- <th>Dr. Name</th> -->
							<th>Status</th>
						</tr>
					</thead>
						@php($current_date = date('y-m-d', strtotime(now())))
						@if($appoints)
						@foreach($appoints as $appoint)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{$appoint->appoint_date}}</td>
							<!-- <td>{{$appoint->dname}}</td> -->
							<td class="text-center">
								@php($appointDate = date('y-m-d', strtotime($appoint->appoint_date)))
								@if($appointDate <  $current_date && $appoint->accept == 0 && $appoint->done == 0 && $appoint->status == 0)
									<span class="badge badge-danger">Absent</span>
								@else
									@if($appoint->accept == 1 && $appoint->done == 0)
									<a href="{{route('doctor.appoint.show',$appoint->id)}}" class="btn btn-padding badge-info">Accepted</a>
									@elseif($appoint->accept == 1 && $appoint->done == 1 && $appoint->status == 0)
									<span class="badge badge-info">Inv. Advised</span>
									@elseif($appoint->accept == 1 && $appoint->done == 1 && $appoint->status == 1)
									    <span class="badge badge-success">Completed</span>
									@elseif($appoint->is_delete == 1 && $appoint->done == 0 && $appoint->status == 0)
									<span class="badge badge-danger">Rejected</span>
									@else
									    <span class="badge badge-warning">Pending</span>
									@endif
								@endif
							</td>
						</tr>
						@endforeach
						@endif
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!-- Advice's History -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			@if($auth == 'Agent')	
				@if(\App\Model\PatientInfo::where('patient_id',$patient->id)->count()>0)
			            <a href="{{ route('agent.seedoctor',\Crypt::encrypt($patient->id)) }}" onclick="event.preventDefault(); seedoctor()" class="btn btn-padding btn-sm btn-info pull-right" id="seedoctor"><i class="fa fa-eye"></i> See Doctor</a>
			    @endif
			@else
			    @if(\App\Model\PatientInfo::where('patient_id',$patient->id)->count()>0)
					@php($doctor = \App\Model\Doctor::where('user_id',Auth::user()->id)->first())
					@if(\App\Model\PatientRequest::where('patient_id',$patient->id)->where('doctor_id',$doctor->id)->where('status',0)->where('is_delete',0)->count() == 0)
					    <a href="{{ route('doctor.payrequest',['doctor_id'=>$doctor->id, 'patient_id'=>$patient->id]) }}" onclick="return confirm('Are you sure?')" class="btn btn-padding btn-sm btn-info pull-right"><i class="fas fa-pencil-alt"></i> Write Advice </a>
				    @endif
			    @endif
			@endif
			<h3 class="widget-title">Advice's Details</h3>
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<!-- <th>History</th> -->
							<!-- <th>Tests</th> -->
							<th>Check up Date</th>
							<!-- <th>Therapist Name</th> -->
							<!-- <th>Report(s)</th> -->
							<th>Advice(s)</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($histories as $history)
							<tr class="text-center">
								<td>{{$loop->index +1}}</td>
								<!-- <td>{{$history->cc}}</td> -->
								<!-- <td>
								@if($history->test == !null)
									@php($testId = explode(', ',$history->test))
									@foreach($testId as $testname)
									@php($test = \App\Model\Test::where('id',$testname)->first())
									{{$test->test_name}}, 
									@endforeach
								@else
									<button class="btn btn-padding btn-sm btn-outline-danger">Not suggested</button>
								@endif
								</td> -->
								<td>{{date('d M Y', strtotime($history->created_at))}}</td>
								<!-- <td>
									{{$history->name}}
									<p style="font-size: 11px;">{{$history->spcialist}}</p>
								</td> -->
								
								<td>
								@if($auth == 'Agent')
									@if(\App\Model\Prescription::where('history_id',$history->id)->count() > 0)
									<a href="{{route('agent.prescription',\Crypt::encrypt($history->id))}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See </a>
									@else
									<button type="button" class="btn btn-padding btn-sm btn-outline-warning mb-0"><i class="fa fa-eye"></i> Not Ready</button>
									@endif
								@else
									@if(\App\Model\History::where('id',$history->id)->count() > 0)
									<a href="{{route('doctor.prescription.show',$history->id)}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>
									@else
									<a href="{{ route('doctor.prescription.edit',$history->request_id) }}" class="btn btn-padding btn-sm btn-outline-info mb-0"><i class="fa fa-eye"></i> Write Advice</a>
									@endif
								@endif
								</td>
	                        </tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<!-- Add Modal -->

<style>
	.modal-content {
	    border-radius: 5px;
	}
</style>

<div class="modal fade" id="smartcard" tabindex="-1" role="dialog" aria-labelledby="smartcard" aria-hidden="true">
  	<div class="modal-dialog modal-md" role="document">
	    <div class="modal-content" style="width: 440px;">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Smart Card</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row border p-2" id="printarea">
					<table class="w-100">
						<tr>
							<th colspan="2">
								<div class="row">
									<div class="col-md-3">
										<img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="height: 35px;">
									</div>
									<div class="col-md-9">
										<h4 class="card-ecoh">Primex Info Sys Ltd</h4>
									</div>								
								</div>
							</th>							
						</tr>
						<tr>
							<td style="width: 112px;">
								<img class="card-image" src="{{$patient->image == !null ? asset('images/patient/'.$patient->image) : asset('images/patient/default.png')}}">
							</td>
							<td>
								<table class="watermark">
									<tr>
										<td colspan="2">
											<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($patient->centre_patient_id, 'C39')}}"  alt="barcode" />
										</td>
									</tr>
									<tr>
										<td>Name</td>
										<td>: {{$patient->name}}</td>
									</tr>
									<tr>
										<td>Address</td>
										<td>: {{$patient->address->name}}</td>
									</tr>
									<tr>
										<td>Birth Year</td>
										<td>: {{date('Y', strtotime($patient->age))}}</td>
									</tr>
									<tr>
										<td>PATIENT ID</td>
										<td>: {{$patient->centre_patient_id}}</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table class="w-100">
						<tr>
							<!-- <td class="card-maintenance">Maintenance by ecohbd.org</td> -->
							<td class="card-develop">Developed by primex-bd.com</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="printid" class="btn btn-padding btn-sm btn-primary"><i class="fas fa-print"></i> Print</button>
			</div>
	    </div>
  	</div>
</div>
<!-- Input On Examination Information -->
<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Input On Examination Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
	      	<form action="{{ $store }}" method="POST">
		      	@csrf
		      	<input type="hidden" name="patient_id" value="{{$patient->id}}">
				<div class="modal-body">
					<div class="row">
                        <div class="form-group col-md-2">
                            <label for="mem_type">Patient Type</label> <span class="text-danger">*</span>
                            <select class="form-control form-control-sm w-100" name="mem_type" id="mem_type" required>
                                <option selected="false" disabled>Select One</option>
                                <option value="OPD" selected>OPD</option>
                                <option value="HCU">HCU</option>
                                <option value="ANC">ANC</option>
                                <option value="CVD">CVD</option>
                                <option value="RHD">RHD</option>
                                <option value="SUR">SUR</option>
                            </select>
                        </div>
                        <!-- <div class="form-group col-md-2">
                            <label for="mem_type">Edu.</label> <span class="text-danger">*</span>
                            <input type="number" name="education" class="form-control form-control-sm" required style="height: 29px;">
                        </div> -->
                        @if($age >= 18)	
                        <div class="form-group col-md-2">
                            <div class="form-group">
                                <div for="recipient-height" class="col-form-label font-weight-bold">Salt</div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="salt" id="saltyes" value="Y">
                                    <label class="form-check-label" for="saltyes">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="salt" id="saltno" value="N">
                                    <label class="form-check-label" for="saltno">N</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="form-group">
                                <div for="recipient-height" class="col-form-label font-weight-bold">SLT</div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="smoke" id="smokeyes" value="Y">
                                    <label class="form-check-label" for="smokeyes">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="smoke" id="smokeno" value="N">
                                    <label class="form-check-label" for="smokeno">N</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="form-group">
                                <div for="recipient-height" class="col-form-label font-weight-bold">Smoking</div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="smoking" id="smokingyes" value="Y">
                                    <label class="form-check-label" for="smokingyes">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="smoking" id="smokingno" value="N">
                                    <label class="form-check-label" for="smokingno">N</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
							<div class="form-group">
								<div for="recipient-weight" class="col-form-label font-weight-bold">DM</div>
								<div class="form-check form-check-inline">
							    <input class="form-check-input" type="radio" name="db" id="dbyes" value="Y">
							    <label class="form-check-label" for="dbyes">Y</label>
							  </div>
							  <div class="form-check form-check-inline">
							    <input class="form-check-input" type="radio" name="db" id="dbno" value="N">
							    <label class="form-check-label" for="dbno">N</label>
							 	</div>
							</div>
						</div>
						@endif
                    </div>
					<div class="row">
						@if($age >= 18)						
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">HTN</div>
									<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="hp" id="hpyes" value="Y">
								    <label class="form-check-label" for="hpyes">Y</label>
								  </div>
								  <div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="hp" id="hpno" value="N">
								    <label class="form-check-label" for="hpno">N</label>
								  </div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">IHD</div>
									<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="ihd" id="ihdyes" value="Y">
								    <label class="form-check-label" for="ihdyes">Y</label>
								  </div>
								  <div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="ihd" id="ihdno" value="N">
								    <label class="form-check-label" for="ihdno">N</label>
								  </div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">Stroke</div>
									<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="strk" id="strkyes" value="Y">
								    <label class="form-check-label" for="strkyes">Y</label>
								  </div>
								  <div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="strk" id="strkno" value="N">
								    <label class="form-check-label" for="strkno">N</label>
								  </div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">COPD</div>
									<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="copd" id="copdyes" value="Y">
								    <label class="form-check-label" for="copdyes">Y</label>
								  </div>
								  <div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="copd" id="copdno" value="N">
								    <label class="form-check-label" for="copdno">N</label>
								  </div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">Cancer</div>
								<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="cancer" id="canceryes" value="Y">
								    <label class="form-check-label" for="canceryes">Y</label>
								</div>
								<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="cancer" id="cancerno" value="N">
								    <label class="form-check-label" for="cancerno">N</label>
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">CKD</div>
								<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="ckd" id="ckdyes" value="Y">
								    <label class="form-check-label" for="ckdyes">Y</label>
								</div>
								<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="ckd" id="ckdno" value="N">
								    <label class="form-check-label" for="ckdno">N</label>
								</div>
							</div>
						</div>
						@endif
					</div>
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<label for="recipient-oxygen" class="col-form-label">O<sub>2</sub> Saturation.</label>
								<input type="number" step="0.01" name="oxygen" class="form-control form-control-sm" id="recipient-oxygen" placeholder="%">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for="recipient-pulse" class="col-form-label">Pulse</label>
								<input type="number" step="0.01" name="pulse" class="form-control form-control-sm" id="recipient-pulse" placeholder="/min">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for="recipient-temp" class="col-form-label">Temp.</label>
								<input type="number" step="0.01" name="temp" class="form-control form-control-sm" id="recipient-temp" placeholder="°F">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for="recipient-weight" class="col-form-label">Weight (kg)</label>
								<input type="number" step="0.01" name="weight" class="form-control form-control-sm" id="weight" placeholder="kg">
							</div>
						</div>
						<div class="col-sm-2">
							@if($patientHeight)
							 @php($height = $patientHeight->height)
							 @else
							 @php($height = '')
							@endif
							<div class="form-group">
								<label for="recipient-height" class="col-form-label">Height (cm)</label>
								<input type="number" step="0.01" name="height" class="form-control form-control-sm" id="height" placeholder="cm" value="{{$age >= 25 ? ($height == null  ? '' : $height) : ''}}">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for="recipient-weight" class="col-form-label">BMI</label>
								<input type="number" step="0.01" name="bmi" class="form-control form-control-sm" id="bmi" placeholder="BMI" readonly>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for="_recipient-sbp" class="col-form-label">SBP</label>
								<input type="text" name="sbp" class="form-control form-control-sm" id="_recipient-sbp" placeholder="mm of Hg">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for="_recipient-dbp" class="col-form-label">DBP</label>
								<input type="text" name="dbp" class="form-control form-control-sm" id="_recipient-dbp" placeholder="mm of Hg">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">Anemia</div>
									<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="anemia" id="anyes" value="Y">
								    <label class="form-check-label" for="anyes">Y</label>
								  </div>
								  <div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="anemia" id="anno" value="N">
								    <label class="form-check-label" for="anno">N</label>
								  </div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">Edema</div>
									<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="edima" id="edyes" value="Y">
								    <label class="form-check-label" for="edyes">Y</label>
								  </div>
								  <div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="edima" id="edno" value="N">
								    <label class="form-check-label" for="edno">N</label>
								  </div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">Jaundice</div>
									<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="jaundice" id="jdyes" value="Y">
								    <label class="form-check-label" for="jdyes">Y</label>
								  </div>
								  <div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="jaundice" id="jdno" value="N">
								    <label class="form-check-label" for="jdno">N</label>
								  </div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label for="heart" class="col-form-label">Heart</label>
								<input type="text" name="heart" class="form-control form-control-sm" id="heart" placeholder="Heart">
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label for="lungs" class="col-form-label">Lungs</label>
								<input type="text" name="lungs" class="form-control form-control-sm" id="lungs" placeholder="Lungs">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="cc" class="col-form-label">Chief Complaints</label>
								<input type="text" name="cc" class="form-control form-control-sm" id="cc" placeholder="Chief Complaints">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<label for="message-text" class="col-form-label">Pre. Date</label>
								<input type="text" name="predate" id="predate" class="form-control form-control-sm" placeholder="Enter Pre. Date" autocomplete="off">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label for="message-text" class="col-form-label">Pre. Dr./Hosp. Name</label>
								<input type="text" name="predochos" id="predochos" class="form-control form-control-sm" placeholder="Enter Previous Doctor/Hospital Name">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="message-text" class="col-form-label">Pre. Symptom</label>
								<input type="checkbox" id="chkbox" class="float-right mt-2" onclick="enableDisable(this)" value="{{$patient->id}}">
								<input type="text" name="presymptom" id="presymptom" class="form-control form-control-sm" placeholder="Enter Previous Symptom">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="message-text" class="col-form-label">Pre. Diagnosis</label>
								<input type="text" name="prediagnosis" id="prediagnosis" class="form-control form-control-sm" placeholder="Enter Previous Diagnosis">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="">
								<label class="col-form-label">Pre. Inv. Findings</label>
								<select class="form-control form-control-sm selectpicker preinvestigation" id="preinvestigation" style="width: 100%;" data-live-search="true">
									<option selected="false" disabled>Select Test</option>
									@foreach($tests as $test)
									<option value="{{$test->test_name}}">{{$test->test_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-12 addTest" id="addTest" style="margin-top: -20px;">

						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<label for="message-text" class="col-form-label">Prev. Treatment (<span class="text-danger">Please don't use comma</span>)</label>

									<button type="button" id="treat" class="btn btn-sm btn-info btn-padding"><i class="fa fa-plus"></i></button>
								</div>

								<div class="col-md-12 addtreat" id="addtreat">

								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<label class="col-form-label">Follow-up Inv. Findings</label>
									<select class="form-control form-control-sm select2" id="followinvestigation" style="width: 100%;">
										<option selected="false" disabled>Select Test</option>
										@foreach($tests as $test)
										<option value="{{$test->test_name}}">{{$test->test_name}}</option>
										@endforeach
									</select>
								</div>

								<div class="col-md-12" id="followaddTest">

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
					<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
				</div>
	      	</form>
	    </div>
  	</div>
</div>
<!-- End Add Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" id="editpatientinfo">
	</div>
</div>
<!-- End Add Modal -->
@endsection


@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
<script src="{{asset('js/select2.full.min.js')}}"></script>
<script>
	// Add on examination add privious history
	function enableDisable(chkbox){
		var patient_id = $("#chkbox").val();
		if (chkbox.checked == true) {
			$("#dnone1").addClass('d-none');
			$("#dnone1").removeAttr('name');
			$("#first_treat").removeAttr('name');
			$("#dnone2").addClass('d-none');
			$.ajax({
				url: "{{route('pre_history')}}",
				method: "POST",
				dataType: "JSON",
				data: {patient_id:patient_id, _token: "{{csrf_token()}}"},
				success: function(data){
					var data = data.data;
					console.log(data);
					if (data[0] == null) {
						Swal.fire("No Previous History Found! Please input manually");
					}else{
						var his = data[0];
						var inv = data[1];
						var treat = data[2];
						$("#predate").val(his.created_at);
						$("#predochos").val(his.dname);
						$("#presymptom").val(his.cc);
						$("#prediagnosis").val(his.diagnosis);

						$.each(inv, function(index, value){
							var html = '<div class="row">'+
								'<div class="col-sm-4">'+
								'<input type="hidden" value="'+value.id+'" class="form-control form-control-sm" name="existid[]">'+
								'</div>'+
								'<div class="col-sm-4">'+
									'<input type="text" value="'+value.test_name+'" class="form-control form-control-sm" name="preinvestigation[]" readonly>'+
								'</div>'+
								'<div class="col-sm-3">'+
									'<input type="text" class="form-control form-control-sm" name="preinvresult[]" placeholder="Enter Result" value="'+value.result+'">'+
								'</div>'+
								'<div class="col-sm-1">'+
									'<button type="button" class="btn btn-sm btn-padding btn-danger remove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
								'</div>'+
							'</div>';
							$("#addTest").append(html);
						});

						$.each(treat, function(index, value){
							var thtml = '<div class="row">'+
											'<div class="col-sm-10">'+
												'<div class="form-group">'+
													'<input type="text" name="pretreatment[]" value="'+value.cat.substring(0,3)+' - '+ value.medname+' - '+ value.mes+' - '+ value.dose_time+' - '+ value.dose_duration+' '+ value.dose_duration_type+'" class="form-control form-control-sm" placeholder="Formulation - Medicine Name doses - Frequency - Duration">'+
                                                    '<input type="hidden" name="dose_time[]" value="'+ value.dose_time+'">'+
                                                    '<input type="hidden" name="dose_qty[]" value="'+ value.dose_qty+'">'+
                                                    '<input type="hidden" name="dose_qty_type[]" value="'+ value.dose_qty_type+'">'+
                                                    '<input type="hidden" name="dose_eat[]" value="'+ value.dose_eat+'">'+
                                                    '<input type="hidden" name="dose_duration[]" value="'+ value.dose_duration+'">'+
                                                    '<input type="hidden" name="dose_duration_type[]" value="'+ value.dose_duration_type+'">'+
												'</div>'+
											'<input type="hidden" value="'+value.price_id+'" name="price_id[]">'+
											'</div>'+
											'<div class="col-sm-1">'+
												'<div class="form-group">'+
													'<button type="button" onclick="treatcheckh()" class="btn btn-sm btn-padding btn-danger tremove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
												'</div>'+
											'</div>'+
										'</div>';
							$("#addtreat").append(thtml);
						});
					}
				},
				error: function(){
					Swal.fire("Something Wrong!");
				}

			});
		}else{
			$("#dnone1").removeClass('d-none');
			$("#dnone2").removeClass('d-none');
			$("#predate").val("");
			$("#predochos").val("");
			$("#presymptom").val("");
			$("#prediagnosis").val("");
			$("#addtreat").empty();
			$("#addTest").empty();
		}
	}
	$("#height, #weight").keyup(function(){
		var weight = $("#weight").val();
		var height = $("#height").val();
		var meter = height / 100;
		var bmi = weight / (meter * meter);
		$("#bmi").val(bmi.toFixed(1));
	})
</script>
<script>
	// Add on examination add new treatment box
	$("#treat").click(function(){
		var html = '<div class="row">'+
					'<div class="col-md-10">'+
						'<div class="form-group">'+
							'<input type="text" name="pretreatment[]" class="form-control form-control-sm" placeholder="Formulation - Medicine Name doses - Frequency - Duration">'+
                                '<input type="hidden" name="dose_time[]" value="0">'+
                                '<input type="hidden" name="dose_qty[]" value="0">'+
                                '<input type="hidden" name="dose_qty_type[]" value="0">'+
                                '<input type="hidden" name="dose_eat[]" value="0">'+
                                '<input type="hidden" name="dose_duration[]" value="0">'+
                                '<input type="hidden" name="dose_duration_type[]" value="0">'+
						'</div>'+
						'<input type="hidden" value="0" name="price_id[]">'+
					'</div>'+
					'<div class="col-sm-2">'+
						'<div class="form-group">'+
							'<button type="button" class="btn btn-sm btn-padding btn-danger tremove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
						'</div>'+
					'</div>'+
				'</div>';
		$("#addtreat").prepend(html);
	});
	$("#addtreat").delegate('.tremove','click', function(){
		$(this).parent().parent().parent().remove();
	});
</script>
<script>
	function seedoctor(){
		console.log($("#seedoctor").attr('href'));
		Swal.fire();
		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: false,

		  allowOutsideClick: false
		})

		swalWithBootstrapButtons.fire({
		  title: 'Are you sure?',
		  text: "Add On Examination today?",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes',
		  cancelButtonText: 'No',
		  reverseButtons: true,
		  allowOutsideClick: false
		}).then((result) => {
		  if (result.value) {
		    event.preventDefault();
		    window.location = $('#seedoctor').attr('href');
		  } else if (
		    result.dismiss === Swal.DismissReason.cancel
		  ) {
		    swalWithBootstrapButtons.fire({
		    	title: 'Opps!',
		      	text: 'Please add an On Examination!',
		    })
		  }
		})
	}
</script>
<script>
	// Add on examination add new previous investigation box
	$("#preinvestigation").change(function(){
		var testName = $(this).val();
		var html = '<div class="row">'+
						'<div class="col-md-4">'+
						'</div>'+
						'<div class="col-md-4">'+
							'<input type="text" value="'+testName+'" class="form-control form-control-sm" name="preinvestigation[]" readonly>'+
						'</div>'+
						'<div class="col-md-3">'+
							'<input type="text" class="form-control form-control-sm" name="preinvresult[]" placeholder="Enter Result">'+
						'</div>'+
						'<div class="col-md-1">'+
							'<button type="button" class="btn btn-sm btn-padding btn-danger remove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
						'</div>'+
					'</div>';
		$("#addTest").prepend(html);
	});

	$('#addTest').delegate('.remove','click', function(){
		$(this).parent().parent().remove();
	});
</script>
<script>
	// Add on examination add new followup investigation box
	$("#followinvestigation").change(function(){
		var testName = $(this).val();
		var html = '<div class="row">'+
						'<div class="col-sm-5">'+
							'<input type="text" value="'+testName+'" class="form-control form-control-sm" name="followinvestigation[]" readonly>'+
						'</div>'+
						'<div class="col-sm-6">'+
							'<input type="text" class="form-control form-control-sm" name="followinvresult[]" placeholder="Enter Result">'+
						'</div>'+
						'<div class="col-sm-1">'+
							'<button type="button" class="btn btn-sm btn-padding btn-danger remove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
						'</div>'+
					'</div>';
		$("#followaddTest").prepend(html);
	});

	$('#followaddTest').delegate('.remove','click', function(){
		$(this).parent().parent().remove();
	});
</script>

<script>

	$(function(){
		$("#printid").click(function(){
			$("#printarea").show();
			window.print();
		});
	});
	$( function() {
		$("#predate").datepicker({
			dateFormat: 'dd-mm-yy',
			maxDate: new Date()
		});
	} );
	$( function() {
		$( "#appoint_date" ).datepicker({
			dateFormat: 'dd-mm-yy',
			minDate: 0
		});
	} );
</script>
<script>
	$('.select2').select2({
      theme: 'bootstrap4'
    });
</script>
<script>
	// On edit on examination
	function edit(id){
		$("#editpatientinfo").empty();
		$("#edittreat").empty();
		if ("{{$auth == 'Doctor'}}") {
			var editUrl = "{{url('/')}}/doctor/patient-info/"+ id;
		}else{
			var editUrl = "{{url('/')}}/agent/patient-info/"+ id;
		}
		$.ajax({
			url: editUrl,
			type: 'GET',
			success:function(data){
				var oe = data.data[0];
				var preinv = data.data[1];
				var pretreatment = data.data[2];
				var followinv = data.data[3];
				if ("{{$auth == 'Doctor'}}") {
					var updateUrl = "{{url('/')}}/doctor/patient-info/"+ oe.id;
				}else{
					var updateUrl = "{{url('/')}}/agent/patient-info/"+ oe.id;
				}
				$("#editpatientinfo").append(
				'<div class="modal-content">'+
			      '<div class="modal-header">'+
			        '<h5 class="modal-title" id="exampleModalLabel">Edit On Examination Information </h5>'+
			        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
			          '<span aria-hidden="true">&times;</span>'+
			        '</button>'+
			      '</div>'+
			      	'<form action="'+ updateUrl +'" method="POST">'+
				      	'@csrf'+
				      	'@method("PUT")'+
				      	'<input type="hidden" name="patient_id" value="{{$patient->id}}">'+
						'<div class="modal-body">'+
							'<div class="row">'+
                                '<div class="form-group col-md-2">'+
                                    '<label for="mem_type">Patient Type</label> <span class="text-danger">*</span>'+
                                    '<select class="form-control form-control-sm w-100" name="mem_type" id="mem_type" required>'+
                                        '<option selected="false" disabled>Select One</option>'+
                                        '<option value="OPD" '+(oe.mem_type == "OPD" ? "selected" : "")+'>OPD</option>'+
                                        '<option value="HCU" '+(oe.mem_type == "HCU" ? "selected" : "")+'>HCU</option>'+
                                        '<option value="ANC" '+(oe.mem_type == "ANC" ? "selected" : "")+'>ANC</option>'+
                                        '<option value="CVD" '+(oe.mem_type == "CVD" ? "selected" : "")+'>CVD</option>'+
                                        '<option value="RHD" '+(oe.mem_type == "RHD" ? "selected" : "")+'>RHD</option>'+
                                        '<option value="SUR" '+(oe.mem_type == "SUR" ? "selected" : "")+'>SUR</option>'+
                                    '</select>'+
                                '</div>'+
		                        '<div class="form-group col-md-2">'+
		                            '<label for="mem_type">Education Year</label> <span class="text-danger">*</span>'+
		                            '<input type="number" name="education" value="'+oe.edu+'" class="form-control form-control-sm" required style="height: 29px;">'+
		                        '</div>'+
		                        '@if($age >= 18)'+
                                '<div class="form-group col-sm-2">'+
                                    '<div class="form-group">'+
                                        '<div for="recipient-height" class="col-form-label font-weight-bold">Salt Intake</div>'+
                                        '<div class="form-check form-check-inline">'+
                                            '<input class="form-check-input" type="radio" name="salt" id="saltyes" '+(oe.salt == "Y" || oe.salt == "Yes" ? "checked" : "")+' value="Y">'+
                                                '<label class="form-check-label" for="saltyes">Y</label>'+
                                        '</div>'+
                                        '<div class="form-check form-check-inline">'+
                                            '<input class="form-check-input" type="radio" name="salt" id="saltno" '+(oe.salt == "N" || oe.salt == "No" ? "checked" : "")+' value="N">'+
                                                '<label class="form-check-label" for="saltno">N</label>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group col-sm-2">'+
                                    '<div class="form-group">'+
                                        '<div for="recipient-height" class="col-form-label font-weight-bold">SLT</div>'+
                                        '<div class="form-check form-check-inline">'+
                                            '<input class="form-check-input" type="radio" name="smoke" id="smokeyes" '+(oe.smoke == "Y" || oe.smoke == "Yes" ? "checked" : "")+' value="Y">'+
                                                '<label class="form-check-label" for="smokeyes">Y</label>'+
                                        '</div>'+
                                        '<div class="form-check form-check-inline">'+
                                            '<input class="form-check-input" type="radio" name="smoke" id="smokeno" '+(oe.smoke == "N" || oe.smoke == "No" ? "checked" : "")+' value="N">'+
                                                '<label class="form-check-label" for="smokeno">N</label>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group col-sm-2">'+
                                    '<div class="form-group">'+
                                        '<div for="recipient-height" class="col-form-label font-weight-bold">Smoking</div>'+
                                        '<div class="form-check form-check-inline">'+
                                            '<input class="form-check-input" type="radio" name="smoking" id="smokingyes" '+(oe.smoking == "Y" || oe.smoking == "Yes" ? "checked" : "")+' value="Y">'+
                                                '<label class="form-check-label" for="smokingyes">Y</label>'+
                                        '</div>'+
                                        '<div class="form-check form-check-inline">'+
                                            '<input class="form-check-input" type="radio" name="smoking" id="smokingno" '+(oe.smoking == "N" || oe.smoking == "No" ? "checked" : "")+' value="N">'+
                                                '<label class="form-check-label" for="smokingno">N</label>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-weight" class="col-form-label font-weight-bold">DM</div>'+
										'<div class="form-check form-check-inline">'+
									    '<input class="form-check-input" type="radio" '+(oe.diabeties == "Y" ? "checked" : "")+' name="db" id="dbyes" value="Y">'+
									    '<label class="form-check-label" for="dbyes">Y</label>'+
									  '</div>'+
									  '<div class="form-check form-check-inline">'+
									    '<input class="form-check-input" type="radio" '+(oe.diabeties == "N" ? "checked" : "")+' name="db" id="dbno" value="N">'+
									    '<label class="form-check-label" for="dbno">N</label>'+
									  '</div>'+
									'</div>'+
								'</div>'+
								'@endif'+
                            '</div>'+
							'<div class="row">'+
								'@if($age >= 18)'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-height" class="col-form-label font-weight-bold">HTN</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.hp == "Y" ? "checked" : "")+' name="hp" id="hpyes" value="Y">'+
										    '<label class="form-check-label" for="hpyes">Y</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.hp == "N" ? "checked" : "")+' name="hp" id="hpno" value="N">'+
										    '<label class="form-check-label" for="hpno">N</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-height" class="col-form-label font-weight-bold">IHD</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.ihd == "Y" ? "checked" : "")+' name="ihd" id="ihdyes" value="Y">'+
										    '<label class="form-check-label" for="ihdyes">Y</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.ihd == "N" ? "checked" : "")+' name="ihd" id="ihdno" value="N">'+
										    '<label class="form-check-label" for="ihdno">N</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-height" class="col-form-label font-weight-bold">Stroke</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.strk == "Y" ? "checked" : "")+' name="strk" id="strkyes" value="Y">'+
										    '<label class="form-check-label" for="strkyes">Y</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.strk == "N" ? "checked" : "")+' name="strk" id="strkno" value="N">'+
										    '<label class="form-check-label" for="strkno">N</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-height" class="col-form-label font-weight-bold">COPD</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.copd == "Y" ? "checked" : "")+' name="copd" id="copdyes" value="Y">'+
										    '<label class="form-check-label" for="copdyes">Y</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.copd == "N" ? "checked" : "")+' name="copd" id="copdno" value="N">'+
										    '<label class="form-check-label" for="copdno">N</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-height" class="col-form-label font-weight-bold">Cancer</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.cancer == "Y" ? "checked" : "")+' name="cancer" id="canceryes" value="Y">'+
										    '<label class="form-check-label" for="canceryes">Y</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.cancer == "N" ? "checked" : "")+' name="cancer" id="cancerno" value="N">'+
										    '<label class="form-check-label" for="cancerno">N</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-height" class="col-form-label font-weight-bold">CKD</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.ckd == "Y" ? "checked" : "")+' name="ckd" id="ckdyes" value="Y">'+
										    '<label class="form-check-label" for="ckdyes">Y</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.ckd == "N" ? "checked" : "")+' name="ckd" id="ckdno" value="N">'+
										    '<label class="form-check-label" for="ckdno">N</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
								'@endif'+
							'</div>'+
							'<div class="row">'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-oxygen" class="col-form-label">O<sub>2</sub> Saturation.</label>'+
										'<input type="number" step="0.01" value="'+oe.oxygen+'" name="oxygen" class="form-control form-control-sm" id="recipient-oxygen">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-pulse" class="col-form-label">Pulse</label>'+
										'<input type="number" step="0.01" value="'+oe.pulse+'" name="pulse" class="form-control form-control-sm" id="recipient-pulse">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-temp" class="col-form-label">Temp.</label>'+
										'<input type="number" step="0.01" value="'+oe.temp+'" name="temp" class="form-control form-control-sm" id="recipient-temp">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="editweight" class="col-form-label">Weight</label>'+
										'<input type="number" step="0.01" onkeyup="body_mi()" value="'+oe.weight+'" name="weight" class="form-control form-control-sm editweight" id="editweight">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="editheight" class="col-form-label">Height</label>'+
										'<input type="number" step="0.01" onkeyup="body_mi()" value="'+oe.height+'" name="height" class="form-control form-control-sm editheight" id="editheight">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="editbmi" class="col-form-label">BMI</label>'+
										'<input type="number" step="0.01" name="bmi" class="form-control form-control-sm editbmi" value="'+oe.bmi+'" id="editbmi" placeholder="BMI" readonly>'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-bp" class="col-form-label">SBP</label>'+
										'<input type="text" value="'+oe.blood_presure+'" name="sbp" class="form-control form-control-sm" id="recipient-sbp">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-bp" class="col-form-label">DBP</label>'+
										'<input type="text" value="'+oe.dbp+'" name="dbp" class="form-control form-control-sm" id="recipient-dbp">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-anemia" class="col-form-label font-weight-bold">Anemia</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="anemia" id="anyes" value="Y" '+(oe.anemia == "Y" ? "checked" : "")+'>'+
										   '<label class="form-check-label" for="anyes">Y</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="anemia" id="anno" value="N" '+(oe.anemia == "N" ? "checked" : "")+'>'+
										    '<label class="form-check-label" for="anno">N</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-edima" class="col-form-label font-weight-bold">Edema</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="edima" id="edyes" value="Y" '+(oe.edima == "Y" ? "checked" : "")+'>'+
										   '<label class="form-check-label" for="anyes">Y</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="edima" id="edno" value="N" '+(oe.edima == "N" ? "checked" : "")+'>'+
										    '<label class="form-check-label" for="anno">N</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
								
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-height" class="col-form-label font-weight-bold">Jaundice</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="jaundice" id="jdyes" value="Y" '+(oe.jaundice == "Y" ? "checked" : "")+'>'+
										   '<label class="form-check-label" for="jdyes">Y</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="jaundice" id="jdno" value="N" '+(oe.jaundice == "N" ? "checked" : "")+'>'+
										    '<label class="form-check-label" for="jdno">N</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="row">'+
								'<div class="col-sm-3">'+
									'<div class="form-group">'+
										'<label for="heart" class="col-form-label">Heart</label>'+
										'<input type="text" name="heart" class="form-control form-control-sm" id="heart" placeholder="Heart" value="'+oe.heart+'">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-3">'+
									'<div class="form-group">'+
										'<label for="lungs" class="col-form-label">Lungs</label>'+
										'<input type="text" name="lungs" class="form-control form-control-sm" id="lungs" placeholder="Lungs"  value="'+oe.lungs+'">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-6">'+
									'<div class="form-group">'+
										'<label for="cc" class="col-form-label">Chief Complaints</label>'+
										'<input type="text" name="cc" class="form-control form-control-sm" id="cc" placeholder="Chief Complaints" value="'+oe.others+'">'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="row">'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-predochos" class="col-form-label">Pre. Date</label>'+
										'<input type="text" value="'+oe.predate+'" name="predate" class="form-control form-control-sm" id="epredate">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-4">'+
									'<div class="form-group">'+
										'<label for="recipient-predochos" class="col-form-label">Pre. Doc./Hos. Name</label>'+
										'<input type="text" value="'+oe.predochos+'" name="predochos" class="form-control form-control-sm" id="recipient-predochos">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-6">'+
									'<div class="form-group">'+
										'<label for="recipient-presymptom" class="col-form-label">Pre. Symptom</label>'+
										'<input type="text" value="'+oe.presymptom+'" name="presymptom" class="form-control form-control-sm" id="recipient-presymptom">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-6">'+
									'<div class="form-group">'+
										'<label for="recipient-prediagnosis" class="col-form-label">Pre. Diagnosis</label>'+
										'<input type="text" value="'+oe.prediagnosis+'" name="prediagnosis" class="form-control form-control-sm" id="recipient-prediagnosis">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-6">'+
									'<div class="form-group">'+
										'<label class="col-form-label">Pre. Inv. Findings</label>'+
										'<select onchange="selecttest()" class="form-control form-control-sm" style="width: 100%; height: 38px;" id="preinvestigation1">'+
											'<option selected="false" disabled>Select Test</option>'+
											'@foreach($tests as $test)'+
											'<option value="{{$test->test_name}}">{{$test->test_name}}</option>'+
											'@endforeach'+
										'</select>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="col-sm-12 addTest1" style="margin-top: -20px;">'+
							'</div>'+
							'<div class="row">'+
								'<div class="col-md-6 edittreat editaddtreat">'+
									'<label for="recipient-predochos" class="col-form-label">Pre. Treatment (<span class="text-danger">Please don\'t use comma</span>)</label> <button type="button" onclick="editaddtreat()" class="btn btn-sm"><i class="fa fa-plus"></i></button>'+
								'</div>'+
								'<div class="col-sm-6">'+
									'<div class="form-group">'+
										'<label class="col-form-label">Follow-up Inv. Findings</label>'+
										'<select onchange="editaddfollow()" class="form-control form-control-sm" style="width: 100%; height: 38px;" id="followinvestigation1">'+
											'<option selected="false" disabled>Select Test</option>'+
											'@foreach($tests as $test)'+
											'<option value="{{$test->test_name}}">{{$test->test_name}}</option>'+
											'@endforeach'+
										'</select>'+
									'</div>'+
									'<div class="col-md-12 editfollow editaddfollow">'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="modal-footer">'+
							'<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal">Close</button>'+
							'<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>'+
						'</div>'+
			        '</form>'+
			    '</div>'
				);

				$.each(preinv, function(index, value){
					var html = '<div class="row">'+
						'<div class="col-sm-3">'+
						'<input type="hidden" value="'+value.id+'" class="form-control form-control-sm" name="existid[]">'+
						'</div>'+
						'<div class="col-sm-3">'+
							'<input type="text" value="'+value.test_name+'" class="form-control form-control-sm" name="preinvestigation1[]" readonly>'+
						'</div>'+
						'<div class="col-sm-3">'+
							'<input type="text" class="form-control form-control-sm" name="preinvresult1[]" placeholder="Enter Result" value="'+value.result+'">'+
						'</div>'+
						'<div class="col-sm-1">'+
							'<button type="button" onclick="checkh()" class="btn btn-sm btn-padding btn-danger editremove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
						'</div>'+
					'</div>';
					$(".addTest1").append(html);
				});

				$.each(pretreatment, function(index, value){
					var thtml = '<div class="row">'+
									'<div class="col-sm-9">'+
										'<div class="form-group">'+
											'<input type="text" name="pretreatment[]" value="'+value.treatment+'" class="form-control form-control-sm" placeholder="Formulation - Medicine Name doses - Frequency - Duration">'+
										'</div>'+
										'<input type="hidden" value="'+value.price_id+'" name="price_id[]">'+
										'<input type="hidden" name="dose_time[]" value="'+ value.dose_time+'">'+
                                        '<input type="hidden" name="dose_qty[]" value="'+ value.dose_qty+'">'+
                                        '<input type="hidden" name="dose_qty_type[]" value="'+ value.dose_qty_type+'">'+
                                        '<input type="hidden" name="dose_eat[]" value="'+ value.dose_eat+'">'+
                                        '<input type="hidden" name="dose_duration[]" value="'+ value.dose_duration+'">'+
                                        '<input type="hidden" name="dose_duration_type[]" value="'+ value.dose_duration_type+'">'+
									'</div>'+
									'<div class="col-sm-1">'+
										'<div class="form-group">'+
											'<button type="button" onclick="treatcheckh()" class="btn btn-sm btn-padding btn-danger tremove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
										'</div>'+
									'</div>'+
								'</div>';
					$(".edittreat").append(thtml);
				});

				$.each(followinv, function(index, value){
					var html = '<div class="row">'+
						'<div class="col-sm-4">'+
							'<input type="text" value="'+value.test_name+'" class="form-control form-control-sm" name="followinvestigation1[]" readonly>'+
						'</div>'+
						'<div class="col-sm-6">'+
							'<input type="text" class="form-control form-control-sm" name="followinvresult1[]" placeholder="Enter Result" value="'+value.result+'">'+
						'</div>'+
						'<div class="col-sm-1">'+
							'<button type="button" onclick="followcheckh()" class="btn btn-sm btn-padding btn-danger follow followremove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
						'</div>'+
					'</div>';
					$(".editfollow").append(html);
				});
			}
		})

	};

	function body_mi(){
		var weight = $(".editweight").val();
		var height = $(".editheight").val();
		var meter = height / 100;
		var bmi = weight / (meter * meter);
		$(".editbmi").val(bmi.toFixed(1));
	};

	// On edit on examination add new treatment box

	function editaddtreat(){
		var html = '<div class="row">'+
					'<div class="col-sm-9">'+
						'<div class="form-group">'+
							'<input type="text" name="pretreatment[]" class="form-control form-control-sm" placeholder="Formulation - Medicine Name doses - Frequency - Duration">'+'<input type="hidden" name="dose_time[]" value="'+ value.dose_time+'">'+
                            '<input type="hidden" name="dose_qty[]" value="0">'+
                            '<input type="hidden" name="dose_qty_type[]" value="0">'+
                            '<input type="hidden" name="dose_eat[]" value="0">'+
                            '<input type="hidden" name="dose_duration[]" value="0">'+
                            '<input type="hidden" name="dose_duration_type[]" value="0">'+
						'</div>'+
						'<input type="hidden" value="0" name="price_id[]">'+
					'</div>'+
					'<div class="col-sm-1">'+
						'<div class="form-group">'+
							'<button type="button" onclick="treatcheckh()" class="btn btn-sm btn-padding btn-danger tremove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
						'</div>'+
					'</div>'+
				'</div>';
		$(".editaddtreat").append(html);
	}

	function treatcheckh(){
		$('.edittreat').delegate('.tremove','click', function(){
			$(this).parent().parent().parent().remove();
		});
	}
	// On edit on examination add new followup investigation box
	function editaddfollow(){
		var testName = $("#followinvestigation1").val();
			var html = '<div class="row">'+
							'<div class="col-sm-4">'+
								'<input type="text" value="'+testName+'" class="form-control form-control-sm" name="followinvestigation1[]" readonly>'+
							'</div>'+
							'<div class="col-sm-6">'+
								'<input type="text" class="form-control form-control-sm" name="followinvresult1[]" placeholder="Enter Result">'+
							'</div>'+
							'<div class="col-sm-1">'+
								'<button type="button" onclick="followcheckh()" class="btn btn-sm btn-padding btn-danger follow followremove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
							'</div>'+
						'</div>';
		$(".editaddfollow").append(html);
	}

	function followcheckh(){
		$('.editaddfollow').delegate('.followremove','click', function(){
			$(this).parent().parent().remove();
		});
	}

	function checkh(){
		$('.addTest1').delegate('.editremove','click', function(){
			$(this).parent().parent().remove();
		});
	}

	function selecttest(){
			var testName = $("#preinvestigation1").val();
			var html = '<div class="row">'+
							'<div class="col-sm-3">'+
								'<input type="hidden" value="" class="form-control form-control-sm" name="existid[]">'+
							'</div>'+
							'<div class="col-sm-3">'+
								'<input type="text" value="'+testName+'" class="form-control form-control-sm" name="preinvestigation1[]" readonly>'+
							'</div>'+
							'<div class="col-sm-3">'+
								'<input type="text" class="form-control form-control-sm" name="preinvresult1[]" placeholder="Enter Result">'+
							'</div>'+
							'<div class="col-sm-1">'+
								'<button type="button" onclick="checkh()" class="btn btn-sm btn-padding btn-danger editremove" style="margin-top: 6px;"><i class="fa fa-trash"></i></button>'+
							'</div>'+
						'</div>';
			$(".addTest1").prepend(html);
	}

	$("#tableId").dataTable({
	    pageLength : 2,
	    lengthMenu: [[2, 10, 20], [2, 10, 20]]
	});
	$("#infotable").dataTable({
	    pageLength : 2,
	    lengthMenu: [[2, 10, 20], [2, 10, 20]]
	});
	$("#appoint_history").dataTable({
	    pageLength : 5,
	    lengthMenu: [[5, 10, 20], [5, 10, 20]]
	});
</script>
<script>
	$(".height, .weight").keyup(function(){
		var weight = $(".weight").val();
		var height = $('.height').val();
		var meter = height / 100;
		var bmi = weight / (meter * meter);
		$("#bmi").val(bmi.toFixed(1));
	})
</script>
<script type="text/javascript">

	$( function() {
		$( "#epredate" ).datepicker({
			dateFormat: 'dd-mm-yy',
		});
	} );
</script>
@endpush
