@extends('layouts.app')
@section('title','All Appointment')

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
@endpush


@section('content')
<div class="row">
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
			<div class="table-responsive mb-3">
				<table id="tableId" class="table table-bordered table-striped">
					<thead>
						<tr>
							{{-- <th class="no-sort">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" id="select-all">
									<label class="custom-control-label" for="select-all"></label>
								</div>
							</th> --}}
							<th>#SL</th>
							<th>ID</th>
							<th>Name</th>
							<th>Age</th>
							<th>Blood Presure</th>
							<th>Blood Suger</th>
							<th>Injury</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($appoints as $appoint)
						@php($histor = \App\Model\History::where('status',0)->where('doctor_id',$appoint->did)->where('patient_id',$appoint->pid)->first())
						{{-- @php(dd($history->status)) --}}
						<tr>
							{{-- <td>
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" id="1">
									<label class="custom-control-label" for="1"></label>
								</div>
							</td> --}}
							<td>{{$loop->index +1}}</td>
							<td>{{$appoint->pid}}</td>
							<td>{{$appoint->name}}</td>
							<td>{{$appoint->age}}</td>
							<td class="text-center">{{$appoint->blood_presure}}</td>
							<td class="text-center">{{$appoint->blood_sugar}}</td>
							<td class="text-center">{{$appoint->injury}}</td>
							<td class="text-center">
							@if($history = \App\Model\History::where('status',0)->where('doctor_id',$appoint->did)->where('patient_id',$appoint->pid)->count() > 0)	
								@if($histor->status == 0)
									<a href="{{route('doctor.appoint.show',$appoint->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-check-circle"></i> Suggested</a>
								@endif
							@else
								<a href="{{route('doctor.appoint.show',$appoint->id)}}" class="btn btn-sm btn-{{$appoint->accept == 0 ?'warning':'info'}}"><i class="fa fa-check-circle"></i> {{$appoint->accept == 0 ?'Accept':'Accepted'}}</a>
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
<script>
	$("#tableId").dataTable();
</script>
@endpush