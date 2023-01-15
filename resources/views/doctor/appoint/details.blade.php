@extends('layouts.app')
@section('title','Details of '.$appoint->name)

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
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
	</div>
</div>
<div class="row">
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
        	@if($appoint->agent_id == Auth::user()->id)
        	@else
            <a href="{{ $calling->room }}" onclick="calling('{{$calling}}'); window.open(this.href,'targetWindow',`toolbar=no, location=no, status=yes, menubar=yes, scrollbars=yes, resizable=yes, width=800, height=600`); return false;"><img src="{{asset('images/call.jpg')}}" style="border-radius: 50%; height: 31px;"></a>
            @endif
            <!-- <a href="#" onclick="calling('{{$calling}}')"><img src="{{asset('images/call.jpg')}}" style="border-radius: 50%; height: 31px;"></a> -->
			@if(\App\Model\History::where('doctor_id',$appoint->did)->where('patient_id',$appoint->id)->where('request_id',$appoint->pare_id)->where('status',0)->count() == 0)
		        <a href="{{ route('doctor.prescription.edit',$appoint->pare_id) }}"><button type="button" class="btn btn-padding btn-info"><i class="fas fa-pencil-alt"></i> Write Advice</button></a>
			@endif
        </div>
    </div>
	<!-- Widget Item -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Patient Info</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td style="width: 22%;"><img style="height: 226px; width: 245px; border-radius: 4px;" src="{{ $appoint->image == !null ? asset('images/patient/'.$appoint->image):asset('images/patient/default.png')}}"></td>
							<td>
								<table class="table table-bordered table-striped">
									<tbody>
										<tr>
											<td><strong>Pt. ID</strong></td>
											<td>{{$appoint->centre_patient_id}}</td>
										</tr>
										<tr>
											<td><strong>Name</strong></td>
											<td>{{$appoint->name}}</td>
										</tr>
										<tr>
											<td><strong>Age</strong> </td>
											@php($age = \Carbon\Carbon::parse($appoint->age)->diff(\Carbon\Carbon::now())->format('%y'))
											<td>{{$age}}</td>
										</tr>
										<tr>
											<td><strong>Gender</strong></td>
											<td>
												{{$appoint->gender == 0 ? 'Male':'Female'}}
											</td>
										</tr>
										<tr>
											<td><strong>Phone </strong></td>
											<td>{{$appoint->phone}}</td>
										</tr>
										<tr>
											<td><strong>Address</strong></td>
											<td>{{$appoint->address}}</td>
										</tr>
										<tr>
											<td><strong>Blood Group</strong></td>
											<td>{{$appoint->blood_group}}</td>
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
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Appoint History</h3>
			<div class="table-responsive">
				<table id="appoint_history" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Date</th>
							<th>Status</th>
						</tr>
					</thead>
						@php($current_date = date('y-m-d', strtotime(now())))
						@if($appoints)
						@foreach($appoints as $app)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{$app->appoint_date}}</td>
							<td class="text-center">
								@php($appDate = date('y-m-d', strtotime($app->appoint_date)))
								@if($appDate <  $current_date && $app->accept == 0 && $app->done == 0 && $app->status == 0)
									<span class="badge badge-danger">Absent</span>
								@else
									@if($app->accept == 1 && $app->done == 0)
									<span class="badge badge-info">Accepted</span>
									@elseif($app->accept == 1 && $app->done == 1 && $app->status == 0)
									<span class="badge badge-info">Inv. Advised</span>
									@elseif($app->accept == 1 && $app->done == 1 && $app->status == 1)
									    <span class="badge badge-success">Completed</span>
									@elseif($app->is_delete == 1 && $app->done == 0 && $app->status == 0)
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
    <!-- /Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Patient's History</h3>
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="text-center">
						<th>#SL</th>
							<!-- <th>Chief Complaints</th> -->
							<th>Check up Date</th>
							<th>Advice(s)</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($histories as $history)
							<tr>
								<td>{{$loop->index +1}}</td>
								<!-- <td>{{$history->cc}}</td> -->
								<td class="text-center">{{date('d M Y', strtotime($history->created_at))}}</td>
								<td class="text-center">

								@if(\App\Model\History::where('id',$history->id)->count() > 0)
									<a href="{{route('doctor.prescription.show',$history->id)}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>
									@else
									<a href="{{ route('doctor.prescription.edit',$history->request_id) }}" class="btn btn-padding btn-sm btn-outline-info mb-0"><i class="fa fa-eye"></i> Write Advice</a>
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
										   '<label class="form-check-label" for="jdyes">Yes</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="jaundice" id="jdno" value="N" '+(oe.jaundice == "N" ? "checked" : "")+'>'+
										    '<label class="form-check-label" for="jdno">No</label>'+
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
</script>
<script>
	function calling(calling) {
		// console.log(calling);
		var calling = calling;
		$.ajax({
			url: '{{route("doctor.calltoagent")}}',
			method: 'POST',
			data: {data: calling, _token: '{{csrf_token()}}'},
			success: function(data){
				// console.log(data);
			}
		});
	}
	$("#appoint_history").dataTable({
	    pageLength : 5,
	    lengthMenu: [[5, 20, 50], [5, 20, 50]]
	});
	$("#infotable").dataTable({
	    pageLength : 2,
	    lengthMenu: [[2, 10, 20, 50], [2, 10, 20, 50]]
	});
	$("#tableId").dataTable({
	    pageLength : 2,
	    lengthMenu: [[2, 10, 20, 50], [2, 10, 20, 50]]
	});
</script>

@endpush
