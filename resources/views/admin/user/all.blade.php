@extends('layouts.app')
@section('title','All User')

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
							<th>Email</th>
							<th>Role</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$user->id}}</td>
							<td>{{$user->name}}</td>
							<td>{{$user->phone}}</td>
							<td>{{$user->email}}</td>
							<td>{{$user->role->name}}</td>
							<td class="text-center">
								@if($user->status == 0)
								<button class="btn btn-padding btn-danger btn-sm"><i class="fa fa-times-circle"></i> Deactive</button>
								@else
								<button class="btn btn-padding btn-success btn-sm"><i class="fa fa-check-circle"></i> Active</button>
								@endif
							</td>
							<td class="text-center">
								<a href="{{route('admin.userpayment',$user->id)}}" class="btn btn-padding btn-sm btn-info"><i class="fa fa-dollar"></i> <i class="fa fa-eye"></i></a>
								<a href="{{route('admin.user.edit',$user->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>
								<form action="{{route('admin.user.destroy', $user->id)}}" method="post"
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