@extends('layouts.app')
@section('title','Details of '.$patient->name)

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
	<!-- Widget Item -->
	<div class="col-md-3">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Patient Details</h3>
			<div class="table-responsive">
				<table class="table table-sm table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong>Name</strong></td>
							<td>{{$patient->name}}</td>
						</tr>
						<tr>
							<td><strong>Age</strong> </td>
							<td>{{$patient->age}}</td>
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
							<td><strong>Bloog Group</strong></td>
							<td>{{$patient->blood_group}}</td>
                        </tr>
						<tr>
							<td><strong>Address</strong></td>
							<td>{{$patient->address}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
	<div class="col-md-9">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Generel Information</h3>
			<div class="table-responsive">
				<table id="infotable" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#SL</th>
							<th>Date</th>
							<th>BP</th>
							<th>Suger</th>
							<th>Pulse</th>
							<th>Temp</th>
							<th>Diabeties</th>
							<th>Injury</th>
							<th>Others</th>
						</tr>
					</thead>
					<tbody>
						@foreach($patientinfos as $info)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{date('d/m/y', strtotime($info->created_at))}}</td>
							<td>{{$info->blood_presure}}</td>
							<td>{{$info->blood_sugar}}</td>
							<td>{{$info->pulse}}</td>
							<td>{{$info->temp}}</td>
							<td>{{$info->diabeties}}</td>
							<td>{{$info->injury}}</td>
							<td>{{$info->others}}</td>
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
								<td class="text-center">
								@if($history->test == !null)
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
									<a href="{{route('pharmacy.history.show',\Crypt::encrypt($history->id))}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>
									@else
                                        @if($history->test == !null)
									        <button type="button" class="btn btn-padding btn-sm btn-outline-info mb-0">Not Added</button>
                                        @else
                                            <button class="btn btn-padding btn-sm btn-danger">No Report</button>
                                        @endif
									@endif
								</td>
								<td class="text-center">
									@if(\App\Model\Prescription::where('history_id',$history->id)->count() > 0)
									<a href="{{route('pharmacy.prescription',\Crypt::encrypt($history->id))}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See </a>
									@else
									<button type="button" class="btn btn-padding btn-sm btn-outline-warning mb-0"><i class="fa fa-eye"></i> Not Ready</button>
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
@endsection


@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>


<script>
	$("#tableId").dataTable();
	$("#infotable").dataTable({
	    pageLength : 3,
	    lengthMenu: [[3, 10, 20, -1], [3, 10, 20, 'Todos']]
	});
</script>

@endpush
