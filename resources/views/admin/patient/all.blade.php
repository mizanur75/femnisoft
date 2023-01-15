@extends('layouts.app')
@section('title','All Patient')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
</style>
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
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#SL</th>
							<th>ID</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Age</th>
							<th>Address</th>
							<th>Blood Group</th>
							<th>Blood Presure</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($patients as $patient)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$patient->id}}</td>
							<td>{{$patient->name}}</td>
							<td>{{$patient->phone}}</td>
							<td>{{$patient->age}}</td>
							<td>{{$patient->address}}</td>
							<td class="text-center">{{$patient->blood_group}}</td>
							<td class="text-center">{{$patient->blood_presure}}</td>
							<td class="text-center">
								@if($patient->status == 0)
								<span class="badge badge-danger">Not Active</span>
								@else
								<span class="badge badge-success">Active</span>
								@endif
							</td>
							<td class="text-center">
								<a href="{{route('admin.patient.show',\Crypt::encrypt($patient->id))}}" class="btn btn-padding btn-sm btn-info" target="_blank"><i class="fa fa-eye"></i></a>
								<a href="{{route('admin.patient.edit',$patient->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>
								<form action="{{route('admin.patient.destroy', $patient->id)}}" method="post"
									style="display: inline;"
									onsubmit="return confirm('Are you Sure? Want to delete')">
									@csrf
									@method('DELETE')
									<button class="btn btn-padding btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i>
									</button>
								</form>
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