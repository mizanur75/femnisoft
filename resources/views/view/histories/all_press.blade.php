@extends('layouts.app')
@section('title', $title.' Advice')

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
								<option selected="false" disabled>-- Select --</option>
                                <option value="">All</option>
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
			<!-- <h3 class="widget-title">Patient Prescription</h3> -->
			<div class="table-responsive">
				<div class="row mb-2">
                    <div class="col-md-3">
                        <form action="{{$title == 'My' ? route('doctor.prescription.index') : route('doctor.allprescription')}}" method="GET">
                        <select class="form-control form-control-sm w-100" name="search_value" onchange="this.form.submit()" style="height:39px;">
                            <option value="20" {{$default_value == 20 ? 'selected' : ''}}>20</option>
                            <option value="50" {{$default_value == 50 ? 'selected' : ''}}>50</option>
                            <option value="100" {{$default_value == 100 ? 'selected' : ''}}>100</option>
                            <option value="500" {{$default_value == 500 ? 'selected' : ''}}>500</option>
                        </select>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <form action="{{route('doctor.search_prescription')}}" method="GET">
                        	<div class="row" style="margin-top: -8px;">
	                        	<div class="col-md-9">
	                        		<input type="text" name="search_prescription" class="form-control form-control-sm" placeholder="Search (Input Client name, phone or ID)">
	                        	</div>
	                        	<div class="col-md-3">
	                        		<button class="btn btn-block btn-info float-right"> <i class="fa fa-search"></i> Search</button>
                        		</div>
                        	</div>
                        </form>
                    </div>
                </div>
				<table id="infotable" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>ID</th>
							<th>Visit</th>
							<th>Client's Name</th>
							<th>Age (Y)</th>
							<th>Address</th>
							<th>Consult. Date</th>
							<th>Advice(s)</th>
						</tr>
					</thead>
					<tbody id="tbody">
						@if($histories)
						@foreach($histories as $history)
						<tr class="text-center">
							<td>{{$history->id}}</td>
							<td>{{$history->ecohid}}</td>
							<td>{{$history->visit}}</td>
							<td>{{$history->patient_name}}</td>
							<td>
								@php
								 $birth_date = new \DateTime($history->dob);
			                     $meet_date = new \DateTime($history->created_at);
			                     $interval = $birth_date->diff($meet_date);
			                     $days = $interval->format('%m M %d D');
			                     $age = $interval->format('%y');
			                     if ($age == 0) {
			                        $age = $days;
			                     }
			                     @endphp
								{{$age}}
							</td>
							<td>{{$history->address}}</td>
							<td>{{date('d M Y', strtotime($history->created_at))}}</td>
							<td>
								@if(\App\Model\Prescription::where('history_id',$history->id)->count() > 0)
						        	<a href="{{route('doctor.prescription.show', $history->id)}}" class="btn btn-padding btn-sm btn-outline-info" target="_blank"><i class="fa fa-eye"></i> See</a>
						        @else
							        @if(Auth::user()->role->id == 3 && $history->did == Auth::user()->id)
							        	<a href="{{route('doctor.prescription.edit',$history->request_id)}}" class="btn btn-padding btn-sm btn-outline-info mb-0" ><i class="fa fa-eye" ></i > Write Advice </a >
							        @else
							        	<a href ="#" class="btn btn-padding btn-sm btn-outline-warning mb-0" ><i class="fa fa-eye" ></i > Not Ready </a >
							        @endif
						        @endif
							</td>
						</tr>
						@endforeach
                        @else
                        <tr>
                        	<td colspan="12" class="text-center text-danger"><h3>Sorry! No data found.</h3></td>
                        </tr>
                        @endif
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

	$(function() {
		$( "#start" ).datepicker({
			dateFormat: 'dd-mm-yy'
		});
	});

	$(function() {
		$( "#finish" ).datepicker({
			dateFormat: 'dd-mm-yy'
		});
	});

</script>
@endpush
