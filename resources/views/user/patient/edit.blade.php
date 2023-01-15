@extends('layouts.app')
@section('title','Add Patient')

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
			<form action="{{route('doctor.patient.update', $patient->id)}}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="form-row">
					
					<div class="form-group col-md-6">
						<label for="patient-name">Name</label> <span class="text-danger">*</span>
						<input type="text" name="name" class="form-control form-control-sm" placeholder="Full Name" value="{{$patient->name}}">
					</div>
					<div class="form-group col-md-6">
						<label for="dob">Age</label> <span class="text-danger">*</span>
						<input type="text" name="age" class="form-control form-control-sm" value="{{$patient->age}}" placeholder="Enter Age">
					</div>
					<div class="form-group col-md-6">
						<label for="phone">Phone</label>
						<input type="text" name="phone" placeholder="Phone" class="form-control form-control-sm"  value="{{$patient->phone}}">
					</div>
					<div class="form-group col-md-6">
						<label for="email">Email</label>
						<input type="email" name="email" placeholder="Email" class="form-control form-control-sm"  value="{{$patient->email}}">
					</div>
					<div class="form-group col-md-6">
						<label for="gender">Gender</label> <span class="text-danger">*</span>
						<select class="form-control form-control-sm" name="gender" id="gender">
							<option selected="false" disabled>Please Select Gender</option>
							<option value="0" {{$patient->gender == 0 ? 'selected':''}}>Male</option>
							<option value="1" {{$patient->gender == 1 ? 'selected':''}}>Female</option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="gender">Marita Status</label> <span class="text-danger">*</span>
						<select class="form-control form-control-sm" name="marital_status" id="gender">
							<option selected="false" disabled>Please Select Marita Status</option>
							<option value="0" {{$patient->gender == 0 ? 'selected':''}}>Single</option>
							<option value="1" {{$patient->gender == 1 ? 'selected':''}}>Married</option>
						</select>
					</div>
					<div class="form-group col-md-12">
						<label for="exampleFormControlTextarea1">Address</label> <span class="text-danger">*</span>
						<textarea name="address" class="form-control" cols="10" rows="3">{{$patient->address}}</textarea>
					</div>
					<div class="form-group col-md-6">
						<label for="blood_group">Blood Group</label>
						<select class="form-control form-control-sm" name="blood_group" id="blood_group">
							<option selected="false" disabled>Please Select Blood Group</option>
							<option value="A+" {{$patient->blood_group == 'A+' ? 'selected':''}}>A+</option>
							<option value="A-" {{$patient->blood_group == 'A-' ? 'selected':''}}>A-</option>
							<option value="B+" {{$patient->blood_group == 'B+' ? 'selected':''}}>B+</option>
							<option value="B-" {{$patient->blood_group == 'B-' ? 'selected':''}}>B-</option>
							<option value="O+" {{$patient->blood_group == 'O+' ? 'selected':''}}>O+</option>
							<option value="O-" {{$patient->blood_group == 'O-' ? 'selected':''}}>O-</option>
							<option value="AB+" {{$patient->blood_group == 'AB+' ? 'selected':''}}>AB+</option>
							<option value="AB-" {{$patient->blood_group == 'AB-' ? 'selected':''}}>AB-</option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="Blood Presure">Blood Presure</label>
						<input type="text" name="blood_presure" placeholder="Blood Presure" class="form-control form-control-sm" value="{{$patient->blood_presure}}">
					</div>
					<div class="form-group col-md-6">
						<label for="Blood Suger">Blood Suger</label>
						<input type="text" name="blood_sugar" placeholder="Blood Suger" class="form-control form-control-sm" value="{{$patient->blood_sugar}}">
					</div>
					<div class="form-group col-md-6">
						<label for="Pulse">Pulse</label>
						<input type="text" name="pulse" placeholder="Pulse" class="form-control form-control-sm"  value="{{$patient->pulse}}">
					</div>
					<div class="form-group col-md-6">
						<label for="exampleFormControlTextarea1">Injury</label>
						<textarea name="injury" class="form-control" cols="10" rows="1"> {{$patient->injury}}</textarea>
					</div>
					<div class="form-group col-md-6">
						<label for="exampleFormControlTextarea1">Picture</label>
						<input type="file" class="form-control form-control-sm" name="image">
						<img src="{{asset('images/patient/'.$patient->image)}}" alt="" height="50">
					</div>
					<div class="form-check col-md-6 mb-2">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="ex-check-2" name="status" value="1" {{$patient->status == 1 ? 'checked':''}}>
								<label class="custom-control-label" for="ex-check-2">Please Confirm</label>
							</div>
						</div>
					</div>
					<div class="form-group col-md-6 mb-3">
						<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Add</button>
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