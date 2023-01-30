@extends('layouts.app')
@section('title','Details of '.$patient->name)

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
</style>
@endpush


@section('content')

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

	@if(\App\Model\PatientInfo::where('patient_id',$patient->id)->count()>0)
	@php($doctor = \App\Model\Doctor::where('user_id',Auth::user()->id)->first())
		@if(\App\Model\PatientRequest::where('patient_id',$patient->id)->where('doctor_id',$doctor->id)->where('status',0)->where('is_delete',0)->count() == 0)
			<div class="col-md-12">
		        <div class="widget-area-2 proclinic-box-shadow text-right">
		            <a href="{{ route('doctor.sendrequest',['doctor_id'=>$doctor->id, 'patient_id'=>$patient->id]) }}" onclick="return confirm('Are you add generel information of this date?')" class="btn btn-padding btn-sm btn-info"><i class="fas fa-pencil-alt"></i> Write Prescription </a>
		        </div>
		    </div>
	    @endif
    @endif
	<!-- Widget Item -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Client Info</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							{{-- <td><strong>Photo</strong></td> --}}
							<td style="width: 22%;"><img style="height: 226px; width: 245px; border-radius: 4px;" src="{{$patient->image == !null ? asset('images/patient/'.$patient->image) : asset('images/patient/default.png')}}"></td>
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
											<td>{{$patient->age}} ({{$age}})</td>
										</tr>
										<tr>
											<td><strong>Sex</strong></td>
											<td>
												{{$patient->gender == 0 ? 'Male':'Female'}}
											</td>
										</tr>										<tr>
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
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Appoint History</h3>
			<div class="table-responsive">
				<table id="appoint_history" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Date</th>
							<th>Dr. Name</th>
							<th>Status</th>
						</tr>
					</thead>
						@php($current_date = date('y-m-d', strtotime(now())))
						@if($appoints)
						@foreach($appoints as $appoint)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{$appoint->appoint_date}}</td>
							<td>{{$appoint->dname}}</td>
							<td class="text-center">
								@php($appointDate = date('y-m-d', strtotime($appoint->appoint_date)))
								@if($appointDate <  $current_date && $appoint->accept == 0 && $appoint->done == 0 && $appoint->status == 0)
									<span class="badge badge-danger">Absent</span>
								@else
									@if($appoint->accept == 1 && $appoint->done == 0)
									<span class="badge badge-info">Accepted</span>
									@elseif($appoint->accept == 1 && $appoint->done == 1 && $appoint->status == 0)
									<span class="badge badge-info">Test Suggested</span>
									@elseif($appoint->accept == 1 && $appoint->done == 1 && $appoint->status == 1)
									    <span class="badge badge-success">Completed</span>
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
    <!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<button class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#addmodal"><i class="fa fa-plus"></i> Add New</button>
			<h3 class="widget-title">Examination Information</h3>
			<div class="table-responsive">
				<table id="infotable" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>SL</th>
							<th>Date</th>
							<th>P. Type</th>
							<th>Ed. Y</th>
							<th>Pre. Diagn.</th>
							<th>SBP</th>
							<th>DBP</th>
							<th>O<sub>2</sub> Satu.</th>
							<th>Pulse</th>
							<th>Temp</th>
							<th>weight</th>
							<th>Height</th>
							@if((substr($patient->age, 0, -1) >= 15) && (substr($patient->age, -1) == "Y"))
							<th>BMI</th>
							@endif
							<th>Edema</th>
							@if((substr($patient->age, 0, -1) >= 18) && (substr($patient->age, -1) == "Y"))
							<th>Diab.</th>
							<th>Hyper.</th>
							@endif
							<th>Anemia</th>
							<th>Heart</th>
							<th>Lungs</th>
							<th>Jaundice</th>
							<th>Pre. Date.</th>
							<th>Pre. Dr/Hos.</th>
							<th>Pre. Sym.</th>
							<!-- <th>Pre. Invest.</th>
							<th>Pre. Treat.</th>
							<th>Follo-up Inv.</th> -->
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($patientinfos as $info)
						<tr class="text-center">
							<td>{{$loop->index + 1}}</td>
							<td>{{date('d M Y', strtotime($info->created_at))}}</td>
							<td>{{$info->mem_type == null ? ($patient->reg_mem == null ? 'OPD' : $patient->reg_mem) : $info->mem_type}}</td>
							<td>{{$info->edu}}</td>
							<td>{{$info->prediagnosis == null ? 'N/A': $info->prediagnosis}}</td>
							<td>{{$info->blood_presure}} mm of Hg</td>
							<td>{{$info->dbp}} mm of Hg</td>
							<td>{{$info->oxygen}}%</td>
							<td>{{$info->pulse}}/min</td>
							<td>{{$info->temp}}°F</td>
							<td>{{$info->weight}} kg</td>
							<td>{{$info->height}} cm</td>
							@if((substr($patient->age, 0, -1) >= 15) && (substr($patient->age, -1) == "Y"))
							<td>
								@php($num = number_format($info->bmi, 2))
								{{$info->bmi}}
								@if($num < 1)
									(N/A)
								@elseif($num > 0 && $num < 18.5)
									(Underweight)
								@elseif($num >= 18.5 && $num <= 24.9)
									(Normal)
								@elseif($num >= 25 && $num <= 29.9)
									(Overweight)
								@else
									(Obese)
								@endif
							</td>
							@endif
							<td>{{$info->edima == 1 ? 'Present': 'Absent'}}</td>
							@if((substr($patient->age, 0, -1) >= 18) && (substr($patient->age, -1) == "Y"))
							<td>{{$info->diabeties == 1 ? 'Yes': 'No'}}</td>
							<td>{{$info->hp == 1 ? 'Yes': 'No'}}</td>
							@endif
							<td>{{$info->anemia == 1 ? 'Yes': 'No'}}</td>
							<td>{{$info->heart == null ? 'N/A': $info->heart}}</td>
							<td>{{$info->lungs == null ? 'N/A': $info->lungs}}</td>
							<td>{{$info->jaundice == 1 ? 'Yes': 'No'}}</td>
							<td>{{$info->predate == null ? 'N/A': $info->predate}}</td>
							<td>{{$info->predochos == null ? 'N/A': $info->predochos}}</td>
							<td>{{$info->presymptom == null ? 'N/A': $info->presymptom}}</td>
							<!-- <td>
								@php($preinvs = \App\Model\Inv::where('info_id',$info->id)->get())
								@foreach($preinvs as $preinv)
								{{$preinv->test_name}} - {{$preinv->result}};
								@endforeach

							</td>
							<td>{{$info->pretreatment == null ? 'N/A': $info->pretreatment}}</td>
							<td>
								@php($followinvs = \App\Model\Finv::where('info_id',$info->id)->get())
								@foreach($followinvs as $finv)
								{{$finv->test_name}} - {{$finv->result}};
								@endforeach
							</td> -->
							<td class="text-center">
								<button type="button" class="btn btn-padding btn-sm btn-primary" data-toggle="modal" data-target="#editmodal" onclick="edit({{$info->id}})"><i class="fa fa-edit"></i></button>
								@php($exist_patient_info = \App\Model\History::where('info_id',$info->id)->count())
								@if($exist_patient_info == 0)
								<form action="{{Auth::user()->role->name == 'Doctor' ? route('doctor.patient-info.destroy',$info->id) : route('agent.patient-info.destroy',$info->id)}}" method="POST" onsubmit="return confirm('Are you Sure? Want to delete')">
									@csrf
									@method('DELETE')
									<button class="btn btn-padding btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i>
                                    </button>
								</form>
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

	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">

			<h3 class="widget-title">Patient's History</h3>
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Chief Complaints</th>
							<th>Inv. Findings</th>
							<th>Check up Date</th>
							<th>Doctor Name</th>
							<th>Report(s)</th>
							<th>Prescription(s)</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($histories as $history)
							<tr>
								<td class="text-center">{{$loop->index +1}}</td>
								<td>{{$history->cc}}</td>
								<td class="text-center">
								@if($history->test != null)
									{{$history->test}}
								@else
									<button class="btn btn-padding btn-sm btn-danger">Not suggested</button>
								@endif
								</td>
								<td class="text-center">{{date('d M Y', strtotime($history->created_at))}}</td>
								<td class="text-center">
									{{$history->name}}
									<p style="font-size: 11px;">{{$history->spcialist}}</p>
								</td>
								<td class="text-center">
									@if(\App\Model\Report::where('history_id',$history->id)->count() > 0)
									<a href="{{route('doctor.reports',$history->id)}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>
									@else
										@if($history->test != null)
										<button class="btn btn-padding btn-sm btn-warning">Not Added</button>
										@else
										<button class="btn btn-padding btn-sm btn-danger">No Report</button>
										@endif
									@endif
								</td>
								<td class="text-center">
									@if(\App\Model\Prescription::where('history_id',$history->id)->count() > 0)
									<a href="{{route('doctor.prescription.show',$history->id)}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>
									@else
									<a href="{{ route('doctor.prescription.edit',$history->request_id) }}" class="btn btn-padding btn-sm btn-outline-info mb-0"><i class="fa fa-eye"></i> Write Prescription</a>
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

<!-- Add Modal -->

<style>
	.modal-content {
	    border-radius: 5px;
	}
</style>

<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Input On Examination Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
	      	<form action="{{ route('doctor.patient-info.store') }}" method="POST">
		      	@csrf
		      	<input type="hidden" name="patient_id" value="{{$patient->id}}">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<label for="recipient-bp" class="col-form-label">BP</label>
								<input type="text" name="bp" class="form-control form-control-sm" id="recipient-bp" placeholder="mm of Hg">
							</div>
						</div>
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
								<label for="recipient-weight" class="col-form-label">Weight</label>
								<input type="number" step="0.01" name="weight" class="form-control form-control-sm" id="weight" placeholder="kg">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for="recipient-height" class="col-form-label">Height</label>
								<input type="number" step="0.01" name="height" class="form-control form-control-sm" id="height" placeholder="cm">
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
								<label for="edima" class="col-form-label">Edema</label>
								<select class="form-control form-control-sm selectpicker" id="edima" name="edima">
									<option selected="false" disabled>Select Edema</option>
									<option value="1">Present</option>
									<option value="0">Absent</option>
								</select>
							</div>
						</div>
						@if((substr($patient->age, 0, -1) >= 18) && (substr($patient->age, -1) == "Y"))
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-weight" class="col-form-label font-weight-bold">Diabetes</div>
								<div class="form-check form-check-inline">
							    <input class="form-check-input" type="radio" name="db" id="dbyes" value="1">
							    <label class="form-check-label" for="dbyes">Yes</label>
							  </div>
							  <div class="form-check form-check-inline">
							    <input class="form-check-input" type="radio" name="db" id="dbno" value="0">
							    <label class="form-check-label" for="dbno">No</label>
							  </div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">Hypertension</div>
									<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="hp" id="hpyes" value="1">
								    <label class="form-check-label" for="hpyes">Yes</label>
								  </div>
								  <div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="hp" id="hpno" value="0">
								    <label class="form-check-label" for="hpno">No</label>
								  </div>
							</div>
						</div>
						@endif
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">Anemia</div>
									<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="anemia" id="anyes" value="1">
								    <label class="form-check-label" for="anyes">Yes</label>
								  </div>
								  <div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="anemia" id="anno" value="0">
								    <label class="form-check-label" for="anno">No</label>
								  </div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div for="recipient-height" class="col-form-label font-weight-bold">Jaundice</div>
									<div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="jaundice" id="jdyes" value="1">
								    <label class="form-check-label" for="jdyes">Yes</label>
								  </div>
								  <div class="form-check form-check-inline">
								    <input class="form-check-input" type="radio" name="jaundice" id="jdno" value="0">
								    <label class="form-check-label" for="jdno">No</label>
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
								<label for="message-text" class="col-form-label">Pre. Dr/Hos. Name</label>
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
								<select class="form-control form-control-sm selectpicker" id="preinvestigation" style="width: 100%;" data-live-search="true">
									<option selected="false" disabled>Select Test</option>
									@foreach($tests as $test)
									<option value="{{$test->test_name}}">{{$test->test_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
							<!-- <div class="col-sm-2">
								<div class="">
									<label class="col-form-label">Appoint Date</label>
									<input type="text" class="form-control form-control-sm" name="appoint_date" id="appoint_date" autocomplete="off">
								</div>
							</div> -->
						<div class="col-sm-12 addTest" id="addTest" style="margin-top: -20px;">

						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-10">
									<div class="form-group">
										<label for="message-text" class="col-form-label">Prev. Treatment (<span class="text-danger">Please don't use comma</span>)</label>
										<input type="text" name="pretreatment[]" id="dnone1" class="form-control form-control-sm" placeholder="Formulation - Medicine Name doses - Frequency - Duration">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group" id="dnone2">
										<label for="message-text" class="col-form-label"></label>
										<button type="button" id="treat" style="margin-top: 38px;" class="btn btn-sm"><i class="fa fa-plus"></i></button>
									</div>
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

	function enableDisable(chkbox){
		var patient_id = $("#chkbox").val();
		if (chkbox.checked == true) {
			$("#dnone1").addClass('d-none');
			$("#dnone2").addClass('d-none');
			$.ajax({
				url: "{{route('pre_history')}}",
				method: "POST",
				dataType: "JSON",
				data: {patient_id:patient_id, _token: "{{csrf_token()}}"},
				success: function(data){
					var data = data.data;
					console.log(data);
					if (data == null) {
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
											'<div class="col-sm-9">'+
												'<div class="form-group">'+
													'<input type="text" name="pretreatment[]" value="'+value.cat.substring(0,3)+' - '+ value.medname+' - '+ value.mes+' - '+ value.dose_time+' - '+ value.dose_duration+' '+ value.dose_duration_type+'" class="form-control form-control-sm" placeholder="Formulation - Medicine Name doses - Frequency - Duration">'+
												'</div>'+
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

	$("#height").keyup(function(){
		var weight = $("#weight").val();
		var height = $(this).val();
		var meter = height / 100;
		var bmi = weight / (meter * meter);
		$("#bmi").val(bmi.toFixed(1));
	})
</script>
<script>
	$("#treat").click(function(){
		var html = '<div class="row">'+
					'<div class="col-sm-7">'+
						'<div class="form-group">'+
							'<input type="text" name="pretreatment[]" class="form-control form-control-sm" placeholder="Formulation - Medicine Name doses - Frequency - Duration">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-1">'+
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
	$("#preinvestigation").change(function(){
		var testName = $(this).val();
		var html = '<div class="row">'+
						'<div class="col-sm-4">'+
						'</div>'+
						'<div class="col-sm-4">'+
							'<input type="text" value="'+testName+'" class="form-control form-control-sm" name="preinvestigation[]" readonly>'+
						'</div>'+
						'<div class="col-sm-3">'+
							'<input type="text" class="form-control form-control-sm" name="preinvresult[]" placeholder="Enter Result">'+
						'</div>'+
						'<div class="col-sm-1">'+
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
	$( function() {
		$( "#predate" ).datepicker({
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
	$('.select2').select2({
      theme: 'bootstrap4'
    });
</script>
<script>
	function edit(id){
		$("#editpatientinfo").empty();
		$.ajax({
			url: "{{url('/')}}/doctor/patient-info/"+ id,
			type: 'GET',
			success:function(data){
				var oe = data.data[0];
				var preinv = data.data[1];
				var pretreatment = data.data[2];
				var followinv = data.data[3];
				$("#editpatientinfo").append(
				'<div class="modal-content">'+
			      '<div class="modal-header">'+
			        '<h5 class="modal-title" id="exampleModalLabel">Edit On Examination Information </h5>'+
			        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
			          '<span aria-hidden="true">&times;</span>'+
			        '</button>'+
			      '</div>'+
			      	'<form action="{{url('/')}}/doctor/patient-info/'+ oe.id +'" method="POST">'+
				      	'@csrf'+
				      	'@method("PUT")'+
				      	'<input type="hidden" name="patient_id" value="{{$patient->id}}">'+
						'<div class="modal-body">'+
							'<div class="row">'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-bp" class="col-form-label">BP</label>'+
										'<input type="text" value="'+oe.blood_presure+'" name="bp" class="form-control form-control-sm" id="recipient-bp">'+
									'</div>'+
								'</div>'+
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
										'<input type="number" onkeyup="body_mi()" step="0.01" value="'+oe.weight+'" name="weight" class="form-control form-control-sm editweight" id="editweight">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="editheight" class="col-form-label">Height</label>'+
										'<input type="number" onkeyup="body_mi()" step="0.01" value="'+oe.height+'" name="height" class="form-control form-control-sm editheight" id="editheight">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="editbmi" class="col-form-label">BMI</label>'+
										'<input type="number" step="0.01" name="bmi" class="form-control form-control-sm editbmi" id="editbmi" value="'+oe.bmi+'" placeholder="BMI" readonly>'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="edima" class="col-form-label">Edema</label>'+
										'<select name="edima" class="form-control form-control-sm" style="width: 100%; height: 38px;" id="edima">'+
											'<option selected="false" disabled>Select Edema</option>'+
											'<option value="1" '+(oe.edima == 1 ? "selected" : "")+'>Present</option>'+
											'<option value="0" '+(oe.edima == 0 ? "selected" : "")+'>Absent</option>'+
										'</select>'+
									'</div>'+
								'</div>'+
								'@if((substr($patient->age, 0, -1) >= 18) && (substr($patient->age, -1) == "Y"))'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-weight" class="col-form-label font-weight-bold">Diabetes</div>'+
										'<div class="form-check form-check-inline">'+
									    '<input class="form-check-input" type="radio" '+(oe.diabeties == 1 ? "checked" : "")+' name="db" id="dbyes" value="1">'+
									    '<label class="form-check-label" for="dbyes">Yes</label>'+
									  '</div>'+
									  '<div class="form-check form-check-inline">'+
									    '<input class="form-check-input" type="radio" '+(oe.diabeties == 0 ? "checked" : "")+' name="db" id="dbno" value="0">'+
									    '<label class="form-check-label" for="dbno">No</label>'+
									  '</div>'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-height" class="col-form-label font-weight-bold">Hypertension</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.hp == 1 ? "checked" : "")+' name="hp" id="hpyes" value="1">'+
										    '<label class="form-check-label" for="hpyes">Yes</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" '+(oe.hp == 0 ? "checked" : "")+' name="hp" id="hpno" value="0">'+
										    '<label class="form-check-label" for="hpno">No</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
								'@endif'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-height" class="col-form-label font-weight-bold">Anemia</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="anemia" id="anyes" value="1" '+(oe.anemia == 1 ? "checked" : "")+'>'+
										   '<label class="form-check-label" for="anyes">Yes</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="anemia" id="anno" value="0" '+(oe.anemia == 0 ? "checked" : "")+'>'+
										    '<label class="form-check-label" for="anno">No</label>'+
										  '</div>'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<div for="recipient-height" class="col-form-label font-weight-bold">Jaundice</div>'+
											'<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="jaundice" id="jdyes" value="1" '+(oe.jaundice == 1 ? "checked" : "")+'>'+
										   '<label class="form-check-label" for="jdyes">Yes</label>'+
										  '</div>'+
										  '<div class="form-check form-check-inline">'+
										    '<input class="form-check-input" type="radio" name="jaundice" id="jdno" value="0" '+(oe.jaundice == 0 ? "checked" : "")+'>'+
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
									'<div class="col-md-12 editaddfollow">'+
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
											'<input type="text" name="pretreatment[]" value="'+value+'" class="form-control form-control-sm" placeholder="Formulation - Medicine Name doses - Frequency - Duration">'+
										'</div>'+
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
					$(".editaddfollow").append(html);
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

	function editaddtreat(){
		var html = '<div class="row">'+
					'<div class="col-sm-9">'+
						'<div class="form-group">'+
							'<input type="text" name="pretreatment[]" class="form-control form-control-sm" placeholder="Formulation - Medicine Name doses - Frequency - Duration">'+
						'</div>'+
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
	$("#tableId").dataTable();
	$("#infotable").dataTable({
	    pageLength : 3,
	    lengthMenu: [[3, 10, 20, -1], [3, 10, 20, 'Todos']]
	});
	$("#appoint_history").dataTable({
	    pageLength : 5,
	    lengthMenu: [[5, 10, 20], [5, 10, 20]]
	});

	$( function() {
		$( "#epredate" ).datepicker({
			dateFormat: 'dd-mm-yy',

		});
	} );
</script>
@endpush
