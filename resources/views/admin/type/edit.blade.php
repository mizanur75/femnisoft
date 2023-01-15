@extends('layouts.app')
@section('title','Edit type')

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
			<form action="{{route('admin.type.update', $type->id)}}" method="POST">
				@csrf
				@method('PUT')
				<div class="form-row">
					
					<div class="form-group col-md-6">
						<label for="type-name">Type Name</label> <span class="text-danger">*</span>
						<input type="text" name="name" class="form-control form-control-sm" placeholder="type Name" value="{{$type->name}}">
					</div>
					<div class="form-group col-md-12">
						<!-- <label for="phone">Remark</label>
						<textarea type="text" name="remark" placeholder="Remark" class="form-control form-control-sm"> {{$type->remark}}</textarea> -->
					</div>
					<div class="form-check col-md-6 mb-2">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="ex-check-2" name="status" value="1" {{$type->status == 1 ? 'checked':''}}>
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