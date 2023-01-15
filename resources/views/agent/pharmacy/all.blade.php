@extends('layouts.app')
@section('title','All Pharmacy')

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
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#SL</th>
							<th>Logo</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Address</th>
							<th>Opent Time</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($pharmacies)
						@foreach($pharmacies as $pharmacy)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td><img src="{{asset('images/pharmacy/'.$pharmacy->logo)}}" alt="{{$pharmacy->name}}" style="height: 40px; border-radius: 50%;"></td>
							<td>{{$pharmacy->name}}</td>
							<td>{{$pharmacy->phone}}</td>
							<td>{{$pharmacy->address}}</td>
							<td>{{$pharmacy->open_time}}</td>
							<td class="text-center">
								@if($pharmacy->status == 0)
								<span class="badge badge-danger">Not Active</span>
								@else
								<span class="badge badge-success">Active</span>
								@endif
							</td>
							<td class="text-center">
								<a href="{{route('agent.pharmacy',$pharmacy->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-eye"></i></a>
							</td>
						</tr>
						@endforeach
						@endif
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