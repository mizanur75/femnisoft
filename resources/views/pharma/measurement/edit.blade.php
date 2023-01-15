@extends('layouts.app')
@section('title','Edit Measurement')

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
			<form action="{{route('pharma.measurement.update', $measurement->id)}}" method="POST">
				@csrf
				@method('PUT')
				<div class="form-row">
					
					<div class="form-group col-md-5">
						<label for="type-name">Measurement Name</label> <span class="text-danger">*</span>
						<input type="text" name="measurement" class="form-control form-control-sm" placeholder="Measurement Name" value="{{$measurement->measurement}}">
					</div>

					<div class="form-group col-md-5">
						<label for="type-name">Quantity</label> <span class="text-danger">*</span>
						<input type="text" name="qty" class="form-control form-control-sm" placeholder="Input Quantity" value="{{$measurement->qty}}">
					</div>

			        <div class="form-check form-check-inline">
			          <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" {{$measurement->status == 1 ? 'checked':''}}>
			          <label class="form-check-label" for="inlineRadio1">Active</label>
			        </div>
			        <div class="form-check form-check-inline">
			          <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0"{{$measurement->status == 0 ? 'checked':''}}>
			          <label class="form-check-label" for="inlineRadio2">Deactive</label>
			        </div>
					<div class="form-group col-md-12 mb-3 text-right">
			        	<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-refresh"></i> Update</button>
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