@extends('layouts.app')
@section('title','Add Medicine/Trade Name')

@push('css')
	<!-- <link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}"> -->
	<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
@endpush


@section('content')
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			@if(Session::has('danger'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>{{ Session::get('danger') }}</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			@endif
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
			<form action="{{route('pharma.medicine.store')}}" method="POST" enctype="multipart/form-data" id="medform">
				@csrf
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="dob">Generic Name</label> <span class="text-danger">*</span>
						<select name="generic_id" class="form-control form-control-sm float-right mb-2 selectpicker show-tick" id="generic_id" data-live-search="true">
							<option selected="false" disabled>===== Select Generic Name =====</option>
							@foreach($generics as $generic)
							<option value="{{$generic->id}}">{{$generic->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="dob">Medicine/Trade Name</label> <span class="text-danger">*</span>
						<input type="text" name="name" placeholder="Enter Medicine Name" class="form-control w-100 form-control-sm">
					</div>
					<div class="form-group col-md-6">
						<label for="dob">Brand Name</label>
						<input type="text" name="brand_name" placeholder="Enter Brand Name" class="form-control w-100 form-control-sm">
					</div>
					<div class="form-group col-md-6">
						<label for="dob">Disease Name</label>
						<input type="text" name="disease" placeholder="Enter Disease Name" class="form-control w-100 form-control-sm">
					</div>
					<div class="form-group col-md-6">
						<label for="phone">Description</label>
						<textarea type="text" name="description" placeholder="Enter Medicine Description" class="form-control w-100 form-control-sm"></textarea>
					</div>
					<div class="form-group col-md-6">
						<label for="phone">Side Effect</label>
						<textarea type="text" name="side_effect" placeholder="Enter Medicine Side Effect" class="form-control w-100 form-control-sm"></textarea>
					</div>
					<div class="form-group col-md-12">
						<label for="phone">Doses</label>
						<textarea type="text" name="doses" placeholder="Enter Medicine Doses" class="form-control w-100 form-control-sm"></textarea>
					</div>
					<div class="form-check col-md-6 mb-2">
						<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" checked>
						<label class="form-check-label" for="inlineRadio1">Active</label>
						</div>
						<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
						<label class="form-check-label" for="inlineRadio2">Deactive</label>
						</div>
					</div>
					<div class="form-group col-md-6 text-right mb-3">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>
<script>
$(function(){
		$('#medform').validate({
			rules: {
				status: "required"
			},
			messages:{
				status: "Please check Status"
			}
		})
	});
</script>
@endpush