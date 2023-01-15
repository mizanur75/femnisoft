@extends('layouts.app')
@section('title','Add Test')

@push('css')
	
@endpush


@section('content')
@php($auth = Auth::user()->role->name)
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
            <a href="{{$auth == 'Agent' ? route('agent.test.index') : route('doctor.test.index')}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-list"></i> All Test</a>
        </div>
    </div>
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
			<form action="{{$auth == 'Agent' ? route('agent.test.store') : route('doctor.test.store')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="form-row">
					
					<div class="form-group col-md-3">
						<label for="Test-name">Test Name</label> <span class="text-danger">*</span>
						<input type="text" name="name" class="form-control form-control-sm" placeholder="Test Name" id="Test-name">
					</div>
					<!-- <div class="form-group col-md-4">
						<label for="dob">Default Value</label> <span class="text-danger">*</span>
						<input type="text" value="0" name="default_value" class="form-control form-control-sm" placeholder="Default Value">
					</div> -->
					<div class="form-group col-md-3">
						<label for="phone">Cost (Tk)</label>
						<input type="number" name="cost" placeholder="Cost" class="form-control form-control-sm" value="0">
					</div>
					<div class="form-group col-md-3">
						<label for="">Status</label> <span class="text-danger">*</span>
						<div class="row pl-3">
							<div class="mr-3">
								<input type="radio" id="active" name="status" class="form-control-sm" value="1" checked>
								<label for="active">Active</label>
							</div>
							<div class="float-right">
								<input type="radio" name="status" class="form-control-sm" id="deactive" value="0">
								<label for="deactive">Deactive</label>
							</div>
						</div>
					</div>
					<div class="form-group col-md-3 mt-3">
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