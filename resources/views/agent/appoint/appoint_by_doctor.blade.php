@extends('layouts.app')
@section('title',$title.' Appointment')

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/mystyle.css')}}">
	<!-- <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}"> -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
.appoint{
	height: 64px;
}
.appoint_c{
	margin-top: -5px;
	margin-right: 5px !important;
}
.search_button{
	height: 36px;
	margin-right: -40px;
}
@media (max-width: 768px){
	.appoint{
		height: 166px !important;
	}
	.appoint_c{
		margin-top: -5px;
		margin-left: -10px;
	}
	.search_button{
		margin-right: 0px;
	}
}
</style>
@endpush


@section('content')
<div class="row">
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right appoint">
			<form action="{{route('agent.appoint_by_doctor_date')}}" method="GET">
				<div class="row float-right appoint_c">
					@if(Request::is('agent/appoint-by-doctor*'))
					<div class="col-md-8">
						@else
					<div class="col-md-5">
					@endif
						<input type="text" name="app_date" id="app_date" class="form-control form-control-sm" autocomplete="off" placeholder="Select Date">
					</div>
					@if(Request::is('agent/appoint-by-doctor*'))
					<input type="hidden" name="doctor_id" value="{{$doctor_id}}">
					@else
					<div class="col-md-5">
						<select name="doctor_id" class="form-control form-control-sm" style="width: 100%; height: 38px;">
							<option selected="false" disabled>Select Doctor</option>
							@foreach($doctors as $doctor)
							<option value="{{$doctor->id}}">{{$doctor->user->name}}</option>
							@endforeach
						</select>
					</div>
					@endif
					<div class="col-md-1">
						<button type="submit" class="btn btn-sm btn-padding btn-outline-info search_button"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>

			</form>
        </div>
    </div>
	<!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">??</span>
				</button>
			</div>
		@endif
			<div class="table-responsive">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">

							<th>#SL</th>
							@if($title == "Today's")
							<th>Today's SL</th>
							@endif
							<th>Pt. ID</th>
							<th>Pt. Type</th>
							<th>Dr. Name</th>
							<th>Pt. Name</th>
							<th>Age (Y)</th>
							<th>Address</th>
							<th>Visit(s)</th>
							<th>Status</th>
							<th>Appoint Date</th>
							<th>Created At</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@php($current_date = date('y-m-d', strtotime(now())))
						@php($index = 0)
						@foreach($appoints as $appoint)
						<tr>

							<td class="text-center">{{$index += 1}}</td>
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
								@php($dob = strlen($appoint->age) < 5 ? now() : $appoint->age)
								@php($age = \Carbon\Carbon::parse($dob)->diff(\Carbon\Carbon::now())->format('%y'))
								@php($month = \Carbon\Carbon::parse($dob)->diff(\Carbon\Carbon::now())->format('%m M'))
								{{$age}} 
								@if($age == 0)
								({{$month}})
								@endif
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
							<td class="text-center">
							@if($history = \App\Model\History::where('status',0)->where('doctor_id',$appoint->did)->where('patient_id',$appoint->pid)->where('request_id',$appoint->id)->count() > 0)

								@php($histor = \App\Model\History::where('status',0)->where('doctor_id',$appoint->did)->where('patient_id',$appoint->pid)->where('request_id',$appoint->id)->first())
								@if($histor->status == 0)
									<a href="{{route('agent.patient.show',\Crypt::encrypt($appoint->pid))}}" class="btn btn-padding btn-sm btn-outline-primary"><i class="fa fa-check-circle"></i> Inv. Advised</a>
								@endif
							@else
								<a href="{{route('agent.patient.show',\Crypt::encrypt($appoint->pid))}}" class="btn btn-padding btn-sm btn-{{$appoint->accept == 0 ?'outline-warning':'outline-info'}}"><i class="fa fa-check-circle"></i> {{$appoint->accept == 0 ?'Accept':'Accepted'}}</a>
							@endif
							</td>
							<td class="text-center">
								@php($appointDate = date('y-m-d', strtotime($appoint->appoint_date)))
								@if($appointDate < $current_date)
								<blink class="blinking">{{date('d M Y', strtotime($appoint->appoint_date))}}</blink>
								@else
								{{date('d M Y', strtotime($appoint->appoint_date))}}
								@endif
							</td>
							<td class="text-center">
								{{date('d M Y', strtotime($appoint->created_at))}}
							</td>
							<td class="text-center">
								<a href="{{ route('agent.edit_appoint',\Crypt::encrypt($appoint->id)) }}" class="btn btn-padding btn-outline-info"> <i class="fa fa-edit"></i> </a>
								<a href="{{ route('agent.deleteappoint',$appoint->id) }}" onclick="return confirm('Are you sure! want to delete')" class="btn btn-padding btn-outline-danger"> <i class="fa fa-times"></i> </a>
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
@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
<script>
	$("#tableId").dataTable({
		pageLength : 50,
	    lengthMenu: [[50, 10, 20, 100, 500], [50, 10, 20, 100, 500]]
	});
</script>
<script>
$(function() {
	$( "#app_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		minDate: 0
	});
});
</script>
@endpush
