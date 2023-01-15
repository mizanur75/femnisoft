@extends('layouts.app')
@section('title','User Permission')

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
						<tr class="text-center">
							<th>#SL</th>
							<th>ID</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Payment</th>
							<th>Status</th>
							<th>Role</th>
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
							<td class="text-center">
								<form action="{{route('admin.paymentset',$user->id)}}" method="GET" onsubmit="return confirm('Are you Sure? Want to change')">
									@if($user->payment == 0)
										<button type="submit" class="btn btn-padding btn-success btn-sm" value="0"><i class="fa fa-times-circle"></i> Not Set</button>
									@elseif($user->payment == 2)
										@if($last_date - $current_date <= 5)
											<button type="submit" class="btn btn-padding btn-warning btn-sm"><i class="fa fa-warning"></i> Warning</button>
										@else
											<button type="submit" class="btn btn-padding btn-danger btn-sm"><i class="fa fa-times-circle"></i> Expired</button>					
										@endif
									@else
									<button type="submit" class="btn btn-padding btn-success btn-sm"><i class="fa fa-check-circle"></i> Ok</button>
									@endif
								</form>
							</td>
							<td class="text-center">
								<form action="{{route('admin.status',$user->id)}}" method="post" onsubmit="return confirm('Are you Sure? Want to change')">
									@csrf
									@method('PUT')
										@if($user->status == 0)
										<input type="hidden" value="1" name="status">
										<button type="submit" class="btn btn-padding btn-success btn-sm" value="0"><i class="fa fa-times-circle"></i> Active</button>
										@else
										<input type="hidden" value="0" name="status">
										<button type="submit" class="btn btn-padding btn-danger btn-sm"><i class="fa fa-check-circle"></i> Deactive</button>
										@endif
								</form>
							</td>
							<form action="{{route('admin.changepermission',$user->id)}}" method="post" onsubmit="return confirm('Are you Sure? Want to change')">
								@csrf
								@method('PUT')
								<td class="text-center">
									<select name="permission" id="" class="form-control form-control-sm" style="width: 100%;">
										@foreach($roles as $role)
										<option value="{{$role->id}}" {{$user->role_id == $role->id ? 'selected':''}}>{{$role->name}}</option>
										@endforeach
									</select>
								</td>
								<td class="text-center">
									<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-lock"></i> Permit</button>
								</td>
							</form>
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