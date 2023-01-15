@extends('layouts.app')
@section('title', $title.' Prescription')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/select2-bootstrap4.min.css')}}">
<!-- <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}"> -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
.search-box{
	    padding: 1px 10px !important;
}

@media (max-width: 768px){
	.search-box{
	    padding: 1px 15px !important;
	}
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

	 <div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow search-box">
			<!-- <div class="float-right col-md-4 p-0" style="margin-top: -8px;"> -->
				<form action="{{route('doctor.pres_show_by_dr_date')}}" method="POST">
					<div class="row">
						@csrf
						<div class="col-md-4">
							<input type="text" name="start" id="start" style="height: 30px;" class="form-control form-control-sm" placeholder="Start Date" @if($start) value="@if($start){{date('d-m-Y', strtotime($start))}}@endif" @endif autocomplete="off">
						</div>
						<div class="col-md-4">
							<input type="text" name="finish" id="finish" style="height: 30px;" class="form-control form-control-sm" placeholder="End Date" @if($finish) value="{{date('d-m-Y', strtotime($finish))}}" @endif autocomplete="off">
						</div>
						<div class="col-md-4">
							<select name="doctor_id" id="doctor_id" onchange="this.form.submit()" style="height: 30px;" class="form-control form-control-sm w-100">
								<option selected="false" disabled>Select Doctor</option>
                                <option value="" {{$doctor_id == null ? 'Selected' : ''}}>All Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{$doctor->id}}" {{$doctor_id == $doctor->id ? 'Selected' : ''}}> {{$doctor->user->name}}</option>
                                @endforeach
                            </select>
						</div>
					</div>
				</form>
			<!-- </div> -->
		</div>
	</div>

	 <div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Patient Prescription</h3>
			<div class="table-responsive">
				<table id="infotable" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>ECOH ID</th>
							<th>Visit</th>
							<th>Pt. Type</th>
							<th>Patient's Name</th>
							<th>Age (Y)</th>
							<th>Address</th>
							<th>Consult. Date</th>
							<th width="15%">Diagnosis</th>
							<th>Doctor's Name</th>
							<th>Report(s)</th>
							<th>Prescription(s)</th>
						</tr>
					</thead>
					<tbody id="tbody">
						@foreach ($histories as $history)
							<tr>
								<td class="text-center">{{$loop->index +1}}</td>
								<td class="text-center">{{$history->ecohid}}</td>
								<td class="text-center">{{$history->visit}}</td>
								<td class="text-center">{{$history->mem_type == null ? ($history->reg_mem == null ? 'OPD' : $history->reg_mem) : $history->mem_type}}</td>
								<td>{{$history->patient_name}}</td>
								<td class="text-center">
								@php
				                    $birth_date = new \DateTime($history->dob);
				                    $meet_date = new \DateTime($history->created_at);
				                    $interval = $birth_date->diff($meet_date);
				                    $days = $interval->format('%mM %dD');
				                    $age = $interval->format('%y');
				                @endphp
								{{$age}}
								</td>
								<td class="text-center">
									{{$history->address}}
								</td>
								<td class="text-center">{{date('d M Y', strtotime($history->created_at))}}</td>
                                <td class="text-center" width="15%">{{$history->diagnosis}}</td>
								<td class="text-center">
									{{$history->name}}
									<p style="font-size: 11px;">{{$history->spcialist}}</p>
								</td>
								<td class="text-center">
									@if(\App\Model\Report::where('history_id',$history->id)->count() > 0)
									<a href="{{route('doctor.reports',$history->id)}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>
									@else
										@if($history->test != null)
										<a href="{{route('doctor.add_reports',$history->id)}}" target="_blank" class="btn btn-padding btn-sm btn-outline-warning"><i class="fa fa-plus"></i> Add</button>
										@else
										<button class="btn btn-padding btn-sm btn-outline-danger">No Report</button>

										@endif
									@endif
									@if($history->suggest_follow_up == '0')
                                	<button onclick="addEdit('{{$history->id}}')" class="btn btn-padding btn-sm btn-outline-warning mb-0" ><i class="fa fa-plus" ></i >/<i class="fa fa-edit" ></i > </button>
									@endif
								</td>
								<td class="text-center">
									@if(\App\Model\Prescription::where('history_id',$history->id)->count() > 0)
									<a href="{{Auth::user()->role->id == 2 ? route('agent.prescription',\Crypt::encrypt($history->id)) : route('doctor.prescription.show',$history->id)}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>
									@else
										@if(Auth::user()->role->id == 3 && $history->did == Auth::user()->id)
											<a href="{{ route('doctor.prescription.edit',$history->request_id) }}" class="btn btn-padding btn-sm btn-outline-info mb-0"><i class="fa fa-eye"></i> Write Prescription</a>
										@else
										<a href="#" class="btn btn-padding btn-sm btn-outline-warning mb-0"><i class="fa fa-eye"></i> Not Ready</a>
										@endif

								@endif
								</td>
	                        </tr>
						@endforeach
					</tbody>
				</table>
                @if($histories)
                    {{$histories->appends(Request::all())->links()}}
                @endif
			</div>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
<div class="modal fade" id="reportForEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Input Export Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
		<form action="{{route('reportForFollowUpExportUpdate')}}" method="POST">
			<div class="modal-body">
					@csrf
					@method('PUT')
                <div class="row" id="reports">
                	
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
				<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fas fa-save"></i> OK </button>
			</div>
		</form>
	    </div>
  	</div>
</div>

@endsection

@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
<script>
    function addEdit(history_id){
    	$("#reports").empty();
    	$("#reportForEdit").modal('show');
    	$.ajax({
    		url: "{{url('/')}}/get-report-for-export/"+history_id,
    		method: "GET",
    		success: function(history){
    			var reports =
    				'<input type="hidden" name="history_id" value="'+history_id+'"/>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-wbc" class="col-form-label">WBC</label>'+
							'<input type="text" name="wbc" class="form-control form-control-sm" id="recipient-wbc" value="'+(history.wbc == null ? " " : history.wbc )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-lym" class="col-form-label">%Lym</label>'+
							'<input type="text" name="lym" class="form-control form-control-sm" id="recipient-lym" value="'+(history.lym == null ? " " : history.lym )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-gra" class="col-form-label">GRA%</label>'+
							'<input type="text" name="gra" class="form-control form-control-sm" id="gra" value="'+(history.gra == null ? " " : history.gra )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-rbc" class="col-form-label">RBC</label>'+
							'<input type="text" name="rbc" class="form-control form-control-sm" id="rbc" value="'+(history.rbc == null ? " " : history.rbc )+'">'+
						'</div>'+
					'</div>'+
    				'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="_recipient-hb" class="col-form-label">HGB</label>'+
							'<input type="text" name="hb" class="form-control form-control-sm" id="_recipient-hb" value="'+(history.hb == null ? " " : history.hb )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-hct" class="col-form-label">HCT</label>'+
							'<input type="text" name="hct" class="form-control form-control-sm" id="hct" value="'+(history.hct == null ? " " : history.hct )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-mcv" class="col-form-label">MCV</label>'+
							'<input type="text" name="mcv" class="form-control form-control-sm" id="mcv" value="'+(history.mcv == null ? " " : history.mcv )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-mch" class="col-form-label">MCH</label>'+
							'<input type="text" name="mch" class="form-control form-control-sm" id="mch" value="'+(history.mch == null ? " " : history.mch )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-mchc" class="col-form-label">MCHC</label>'+
							'<input type="text" name="mchc" class="form-control form-control-sm" id="mchc" value="'+(history.mchc == null ? " " : history.mchc )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-plt" class="col-form-label">PLT</label>'+
							'<input type="text" name="plt" class="form-control form-control-sm" id="plt" value="'+(history.plt == null ? " " : history.plt )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="_recipient-esr" class="col-form-label">ESR</label>'+
							'<input type="text" name="esr" class="form-control form-control-sm" id="_recipient-esr" value="'+(history.esr == null ? " " : history.esr )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-neu" class="col-form-label">%Neu</label>'+
							'<input type="text" name="neu" class="form-control form-control-sm" id="recipient-neu" value="'+(history.neu == null ? " " : history.neu )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-chol" class="col-form-label">Chol</label>'+
							'<input type="text" name="chol" class="form-control form-control-sm" id="chol" value="'+(history.chol == null ? " " : history.chol )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-tg" class="col-form-label">TG</label>'+
							'<input type="text" name="tg" class="form-control form-control-sm" id="recipient-tg" value="'+(history.tg == null ? " " : history.tg )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-glucf" class="col-form-label">Gluc-f</label>'+
							'<input type="text" name="glucf" class="form-control form-control-sm" id="glucf" value="'+(history.glucf == null ? " " : history.glucf )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-glucr" class="col-form-label">Gluc-r</label>'+
							'<input type="text" name="glucr" class="form-control form-control-sm" id="glucr" value="'+(history.glucr == null ? " " : history.glucr )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-gluc2hr" class="col-form-label">Gluc-2hr</label>'+
							'<input type="text" name="gluc2hr" class="form-control form-control-sm" id="gluc2hr" value="'+(history.gluc2hr == null ? " " : history.gluc2hr )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-creat" class="col-form-label">Creat</label>'+
							'<input type="text" name="creat" class="form-control form-control-sm" id="creat" value="'+(history.creat == null ? " " : history.creat )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-ua" class="col-form-label">UA</label>'+
							'<input type="text" name="ua" class="form-control form-control-sm" id="ua" value="'+(history.ua == null ? " " : history.ua )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-crp" class="col-form-label">CRP</label>'+
							'<input type="text" name="crp" class="form-control form-control-sm" id="recipient-crp" value="'+(history.crp == null ? " " : history.crp )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-ra" class="col-form-label">RA</label>'+
							'<input type="text" name="ra" class="form-control form-control-sm" id="ra" value="'+(history.ra == null ? " " : history.ra )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-ugl" class="col-form-label">U-gl</label>'+
							'<input type="text" name="ugl" class="form-control form-control-sm" id="ugl" value="'+(history.ugl == null ? " " : history.ugl )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-upr" class="col-form-label">U-pr</label>'+
							'<input type="text" name="upr" class="form-control form-control-sm" id="upr" value="'+(history.upr == null ? " " : history.upr )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-uery" class="col-form-label">U-ery</label>'+
							'<input type="text" name="uery" class="form-control form-control-sm" id="uery" value="'+(history.uery == null ? " " : history.uery )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-uleu" class="col-form-label">U-leu</label>'+
							'<input type="text" name="uleu" class="form-control form-control-sm" id="uleu" value="'+(history.uleu == null ? " " : history.uleu )+'">'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-ecg" class="col-form-label">ECG</label>'+
							'<select name="ecg" class="form-control form-control-sm w-100" id="ecg">'+
								'<option selected="false" value="">N/A</option>'+
								'<option value="WNL" '+(history.ecg == "WNL" ? "selected" : "") +'>WNL</option>'+
								'<option value="AMI" '+(history.ecg == "AMI" ? "selected" : "") +'>AMI</option>'+
								'<option value="IHD" '+(history.ecg == "IHD" ? "selected" : "") +'>IHD</option>'+
								'<option value="LVH" '+(history.ecg == "LVH" ? "selected" : "") +'>LVH</option>'+
								'<option value="Arrhythmia" '+(history.ecg == "Arrhythmia" ? "selected" : "") +'>Arrhythmia</option>'+
								'<option value="Others" '+ (history.ecg == "Others" ? "selected" : "")+'>Others </option>'+
							'</select>'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-usg" class="col-form-label">USG</label>'+
							'<select name="usg" class="form-control form-control-sm w-100" id="usg">'+
								'<option selected="false" value="">N/A</option>'+
								'<option value="Normal" '+(history.usg == "Normal" ? "selected" : "") +'>Normal</option>'+
								'<option value="Pregnancy" '+(history.usg == "Pregnancy" ? "selected" : "") +'>Pregnancy</option>'+
								'<option value="Abnormal" '+(history.usg == "Abnormal" ? "selected" : "") +'>Abnormal</option>'+
							'</select>'+
						'</div>'+
					'</div>'+
					'<div class="col-sm-4">'+
						'<div class="form-group">'+
							'<label for="recipient-cxr" class="col-form-label">CXR</label>'+
							'<select name="cxr" class="form-control form-control-sm w-100" id="cxr">'+
								'<option selected="false" value="">N/A</option>'+
								'<option value="Normal" '+(history.cxr == "Normal" ? "selected" : "") +'>Normal</option>'+
								'<option value="RTI" '+(history.cxr == "RTI" ? "selected" : "") +'>RTI</option>'+
								'<option value="Cardiomegaly" '+(history.cxr == "Cardiomegaly" ? "selected" : "") +'>Cardiomegaly</option>'+
								'<option value="TB" '+(history.cxr == "TB" ? "selected" : "")+'>TB</option>'+
								'<option value="Others" '+(history.cxr == "Others" ? "selected" : "") +'>Others </option>'+
							'</select>'+
						'</div>'+
					'</div>';
				$("#reports").append(reports);
    		}

    	});
    }

    $(function(){
        $("#infotable").dataTable();
    });

	$(function() {
		$( "#start" ).datepicker({
			dateFormat: 'dd-mm-yy',
			maxDate: 0
		});
	});

	$(function() {
		$( "#finish" ).datepicker({
			dateFormat: 'dd-mm-yy',
			maxDate: 0
		});
	});
	$(document).keypress(
	  function(event){
	    if (event.which == '13') {
	    	$("#reportForEdit").modal('show');
	      	event.preventDefault();
	    }
	});
</script>
@endpush
