@extends('layouts.app')
@section('title','Review')

@push('css')
	<link rel="stylesheet" href="{{asset('assets/css/mystyle.css')}}">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush


@section('content')
@php($auth = Auth::user()->role->name)
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
            <a href="{{route('doctor.web-testimonial.index')}}" class="btn btn-padding btn-sm btn-success"><i class="fa fa-list"></i> All Blogs</a>
        </div>
    </div>
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
			<form action="{{route('doctor.web-testimonial.store')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="form-row">
					<div class="form-group col-md-12">
						<label for="patient-name">Name</label> <span class="text-danger">*</span>
						<input type="text" value="{{old('name')}}" name="name" class="form-control form-control-sm" placeholder="Full Name" id="patient-name" required>
					</div>

					<div class="form-group col-md-12">
						<label for="exampleFormControlTextarea1">Speech</label> <span class="text-danger">*</span>
						<textarea name="description" id="nic-edit" class="form-control" cols="10" rows="3">{{old('description')}}</textarea>
					</div>
					<div class="form-group col-md-6">
						<div class="form-row">
							<div class="form-group col-md-11" id="photo">
								<input type="file" name="photo">
							</div>
						</div>
					</div>
					<div class="form-check col-md-6">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="ex-check-2" name="status" value="1" required>
								<label class="custom-control-label" for="ex-check-2">Please Confirm</label>
							</div>
						</div>
					</div>
					<div class="form-group col-md-6">
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
    <script src="{{asset('assets/js/nicEdit.js')}}"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(function() { new nicEditor().panelInstance('nic-edit'); });
    </script>
@endpush
