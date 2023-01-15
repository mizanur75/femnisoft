@extends('layouts.app')
@section('title','Details of '.$appoint->name)

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
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
	@if(\App\Model\History::where('doctor_id',$appoint->did)->where('patient_id',$appoint->id)->where('status',0)->count() == 0)
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right">
            <a href="{{ route('doctor.prescription.show',$appoint->pare_id) }}"><button type="button" class="btn btn-info mb-3"><i class="fa fa-pencil"></i> Write Prescription</button></a>
        </div>
    </div>
	@endif
	<!-- Widget Item -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Patient Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>											
							<td><strong>Name</strong></td>
							<td>{{$appoint->name}}</td>
						</tr>
						<tr>
							<td><strong>Age</strong> </td>
							<td>{{$appoint->age}}</td>
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
							<td><strong>Email</strong></td>
							<td>{{$appoint->email}}</td>
                        </tr>
						<tr>
							<td><strong>Address</strong></td>
							<td>{{$appoint->address}}</td>
						</tr>								
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Generel Information</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>											
							<td><strong>Bloog Group</strong></td>
							<td>{{$appoint->blood_group}}</td>
						</tr>
						<tr>
							<td><strong>Bloog Presure</strong> </td>
							<td>{{$appoint->blood_presure}}</td>
						</tr>
						<tr>
							<td><strong>Bloog Suger</strong></td>
							<td>
								{{$appoint->blood_sugar}}
							</td>
						</tr>
						<tr>
							<td><strong>Pulse </strong></td>
							<td>{{$appoint->pulse}}</td>
						</tr>
						<tr>
							<td><strong>Injury</strong></td>
							<td>{{$appoint->injury}}</td>
                        </tr>
						<tr>
							<td><strong>Address</strong></td>
							<td>{{$appoint->address}}</td>
						</tr>								
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <!-- /Widget Item -->

	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Patient History</h3>
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="text-center">										
						<th>#SL</th>
							<th>Description</th>
							<th>Tests</th>
							<th>Check up Date</th>
							<th>Doctor Name</th>
							<th>Report(s)</th>
							<th>Prescription(s)</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($histories as $history)
							<tr>											
								<td>{{$loop->index +1}}</td>
								<td>{{$history->description}}</td>
								<td>{{$history->test}}</td>
								<td class="text-center">{{date('d M Y', strtotime($history->created_at))}}</td>
								<td class="text-center">
									{{$history->name}}
									<p style="font-size: 11px;">{{$history->spcialist}}</p>
								</td>
								<td class="text-center">
								@if(\App\Model\Report::where('history_id',$history->id)->count() > 0)
									<a href="{{route('doctor.reports',$history->id)}}" class="btn btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>
								@else
								<button type="button" class="btn btn-sm btn-warning mb-0"><i class="fa fa-close"></i> No Test</a>
								@endif
								</td>
								<td class="text-center">
								
								@if(\App\Model\Prescription::where('history_id',$history->id)->count() > 0)
									<a href="{{route('doctor.appoint.edit',$history->id)}}" class="btn btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>
									@else
									<a href="{{ route('doctor.prescription.show',$history->request_id) }}" class="btn btn-sm btn-outline-info mb-0"><i class="fa fa-eye"></i> Write Prescription</a>
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
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>

<script>
	$("#tableId").dataTable();
</script>

@endpush