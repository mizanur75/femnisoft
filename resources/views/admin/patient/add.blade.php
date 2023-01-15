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
			<form action="{{route('admin.patient.store')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="form-row">
					
					<div class="form-group col-md-6">
						<label for="patient-name">Name</label> <span class="text-danger">*</span>
						<input type="text" name="name" class="form-control form-control-sm" placeholder="Full Name" id="patient-name">
					</div>
					<div class="form-group col-md-6">
						<label for="dob">Age</label> <span class="text-danger">*</span>
						<input type="text" name="age" class="form-control form-control-sm" placeholder="Enter Age">
					</div>
					<div class="form-group col-md-6">
						<label for="phone">Phone</label>
						<input type="text" name="phone" placeholder="Phone" class="form-control form-control-sm" id="phone">
					</div>
					<div class="form-group col-md-6">
						<label for="email">Email</label>
						<input type="email" name="email" placeholder="Email" class="form-control form-control-sm" id="Email">
					</div>
					<div class="form-group col-md-6">
						<label for="gender">Gender</label> <span class="text-danger">*</span>
						<select class="form-control form-control-sm" name="gender" id="gender">
							<option selected="false" disabled>Please Select Gender</option>
							<option value="0">Male</option>
							<option value="1">Female</option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="gender">Marita Status</label> <span class="text-danger">*</span>
						<select class="form-control form-control-sm" name="marital_status" id="gender">
							<option selected="false" disabled>Please Select Marita Status</option>
							<option value="0">Single</option>
							<option value="1">Married</option>
						</select>
					</div>
					<div class="form-group col-md-12">
						<label for="exampleFormControlTextarea1">Address</label> <span class="text-danger">*</span>
						<textarea name="address" class="form-control" cols="10" rows="3"></textarea>
					</div>
					<div class="form-group col-md-6">
						<label for="blood_group">Blood Group</label>
						<select class="form-control form-control-sm" name="blood_group" id="blood_group">
							<option selected="false" disabled>Please Select Blood Group</option>
							<option value="A+">A+</option>
							<option value="A-">A-</option>
							<option value="B+">B+</option>
							<option value="B-">B-</option>
							<option value="O+">O+</option>
							<option value="O-">O-</option>
							<option value="AB+">AB+</option>
							<option value="AB-">AB-</option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="Blood Presure">Blood Presure</label>
						<input type="text" name="blood_presure" placeholder="Blood Presure" class="form-control form-control-sm" id="Blood Presure">
					</div>
					<div class="form-group col-md-6">
						<label for="Blood Suger">Blood Suger</label>
						<input type="text" name="blood_sugar" placeholder="Blood Suger" class="form-control form-control-sm" id="Blood Suger">
					</div>
					<div class="form-group col-md-6">
						<label for="Pulse">Pulse</label>
						<input type="text" name="pulse" placeholder="Pulse" class="form-control form-control-sm" id="Pulse">
					</div>
					<div class="form-group col-md-6">
						<label for="exampleFormControlTextarea1">Injury</label>
						<textarea name="injury" class="form-control" cols="10" rows="1"></textarea>
					</div>
					<div class="form-group col-md-6">
						<label for="exampleFormControlTextarea1">Picture</label>
						<input type="file" class="form-control form-control-sm" name="image">
					</div>
					<div class="form-check col-md-6 mb-2">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="ex-check-2" name="status" value="1">
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