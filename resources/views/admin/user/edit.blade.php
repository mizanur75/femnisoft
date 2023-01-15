@extends('layouts.app')
@section('title','Edit User')

@push('css')
	
@endpush


@section('content')
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			@if($errors->any())
			@foreach($errors->all() as $error)
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<strong>Opps!</strong> {{$error}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			@endforeach
			@endif
			<form action="{{route('admin.user.update',$user->id)}}" method="POST" enctype="multipart/form-data">
				@csrf
                @method('PUT')
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="dob">Role</label>
						<select name="role_id" id="" class="form-control form-control-sm">
							<option selected="false" disabled>Please Select a Role</option>
							@foreach($roles as $role)
							<option value="{{$role->id}}" {{$user->role_id == $role->id ? 'selected':''}}>{{$role->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="patient-name">Name</label>
						<input type="text" name="name" class="form-control form-control-sm" value="{{$user->name}}" id="patient-name">
					</div>
					<div class="form-group col-md-6">
						<label for="age">Username</label>
						<input type="text" name="username"  value="{{$user->username}}" readonly class="form-control form-control-sm" id="age">
					</div>
					<div class="form-group col-md-6">
						<label for="phone">Phone</label>
						<input type="text" name="phone" value="{{$user->phone}}" class="form-control form-control-sm" id="phone">
					</div>
					<div class="form-group col-md-6">
						<label for="email">Email</label>
						<input type="email" name="email" value="{{$user->email}}" readonly class="form-control form-control-sm" id="Email">
					</div>
					<div class="form-group col-md-3">
						<label for="gender">Gender</label>
						<select class="form-control form-control-sm" name="gender" id="gender">
							<option selected="false" disabled>Please Select Gender</option>
							<option value="0" {{$user->gender == 0 ? 'selected':''}}>Male</option>
							<option value="1" {{$user->gender == 1 ? 'selected':''}}>Female</option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="gender">Instalment Payment</label>
						<input type="number" name="amount" placeholder="Enter Monthly Installment Amount" class="form-control form-control-sm" id="amount" value="{{$user->amount}}">
					</div>
					<div class="form-group col-md-6">
						<label for="exampleFormControlTextarea1">Password</label>
						<input type="password" class="form-control form-control-sm" name="password" value="{{$user->password}}">
					</div>
					<div class="form-group col-md-6">
						<label for="file">File</label>
						<input type="file" class="form-control form-control-sm" id="file">
					</div>
														
					<div class="form-check col-md-6 mb-2">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="ex-check-2" required>
								<label class="custom-control-label" for="ex-check-2">Please Confirm</label>
							</div>
						</div>
					</div>
					<div class="form-group col-md-6 mb-3">
						<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-refresh"></i> Update</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
@endsection


@push('scripts')

@endpush