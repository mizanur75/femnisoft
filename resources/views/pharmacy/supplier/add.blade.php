@extends('layouts.app')
@section('title','Add Test')

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
			<form action="{{route('admin.test.store')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="form-row">
					
					<div class="form-group col-md-6">
						<label for="Test-name">Test Name</label> <span class="text-danger">*</span>
						<input type="text" name="name" class="form-control form-control-sm" placeholder="Test Name" id="Test-name">
					</div>
					<div class="form-group col-md-6">
						<label for="dob">Default Value</label> <span class="text-danger">*</span>
						<input type="text" name="default_value" class="form-control form-control-sm" placeholder="Default Value">
					</div>
					<div class="form-group col-md-12">
						<label for="phone">Remark</label>
						<textarea type="text" name="remark" placeholder="Remark" class="form-control form-control-sm"></textarea>
					</div>
					<div class="form-check col-md-6 mb-2">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="ex-check-2" name="status" value="1" required>
								<label class="custom-control-label" for="ex-check-2">Please Confirm</label>
							</div>
						</div>
					</div>
					<div class="form-group col-md-6 mb-3">
						<button type="submit" class="btn btn-padding btn-primary btn-block"><i class="fa fa-plus"></i> Add</button>
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