@extends('layouts.app')
@section('title','Online Appointment')

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
}
.search_button{
	height: 36px;
	margin-right: -74px;
}
@media (max-width: 768px){
	.appoint{
		height: 114px !important;
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
	<!-- <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right appoint">
			<form action="{{route('doctor.appoint_by_doctor_date')}}" method="GET">
				<div class="row float-right appoint_c">
					<div class="col-md-7">
						<input type="text" name="app_date" id="app_date" class="form-control form-control-sm" autocomplete="off" placeholder="Select Date">
					</div>
					<div class="col-md-1">
						<button type="submit" class="btn btn-sm btn-padding btn-info search_button"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>

			</form>
        </div>
    </div> -->
	<!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endif
			<div class="table-responsive">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<!-- <th>Dr. Name</th> -->
							<th>Client Name</th>
							<th>Phone</th>
							<th>Create Date</th>
							<th>Appt. Date</th>
							<th>Appt. Time</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($online_appoints as $appoint)
						<tr>
							<td class="text-center" class="text-center">{{$loop->index +1}}</td>
							<!-- <td class="text-center">{{$appoint->doctor_id == 1 ? 'Ashraful Haque':''}}</td> -->
							<td class="text-center">{{$appoint->name}}</td>
							<td class="text-center">{{$appoint->phone}}</td>
							<td class="text-center">{{date('d M Y', strtotime($appoint->created_at))}}</td>
							<td class="text-center">{{date('d M Y', strtotime($appoint->dates))}}</td>
							<td class="text-center">{{date('h:i A', strtotime($appoint->times))}}</td>
							<td class="text-center">
								@if($appoint->is_accept == null)
									<a href="{{route('doctor.accept',$appoint->id)}}" class="btn btn-sm btn-padding btn-outline-success" onclick="return confirm('Are you sure!')">
										<i class="fa fa-check-circle"></i> Accept
									</a>
									<a href="{{route('doctor.declined',$appoint->id)}}" class="btn btn-sm btn-padding btn-outline-danger" onclick="return confirm('Are you sure!')">
										<i class="fa fa-times-circle"></i> Decline
									</a>
								@else
									<a href="{{route('doctor.patient_exist',$appoint->id)}}" class="btn btn-sm btn-padding btn-outline-info" onclick="return confirm('Are you sure!')">
										<i class="fa fa-check-circle"></i> Create Advice
									</a>
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
@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
<script>
	$("#tableId").dataTable({
        pageLength : 20,
        lengthMenu: [[20, 10, 50, 100, 500], [20, 10, 50, 100, 500]]
    });

$(function() {
	$( "#app_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		minDate: 0
	});
});
</script>
@endpush
