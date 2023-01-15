@extends('layouts.app')
@section('title','All Test')

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
@php($auth = Auth::user()->role->name)
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
            <a href="{{$auth == 'Agent' ? route('agent.test.create') : route('doctor.test.create')}}" class="btn btn-padding btn-sm btn-info"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
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
							<th>ID</th>
							<th>Test Name</th>
							<!-- <th>Default Value</th> -->
							<th>Cost (Tk)</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($tests as $test)
						<tr class="text-center">
							<td>{{$loop->index +1}}</td>
							<td>{{$test->id}}</td>
							<td>{{$test->test_name}}</td>
							<!-- <td>{{$test->default_value}}</td> -->
							<td>{{$test->cost}}</td>
							<td>
								@if($test->status == 1)
								<span class="badge badge-success">Active</span>
								@else
								<span class="badge badge-danger">Deactive</span>
								@endif
							</td>
							<td class="text-center">
								<a href="{{$auth == 'Agent' ? route('agent.test.edit',\Crypt::encrypt($test->id)) : route('doctor.test.edit',\Crypt::encrypt($test->id))}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>
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