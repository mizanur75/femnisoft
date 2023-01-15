@extends('layouts.app')
@section('title','Edit Customer'.$customer->name)

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
			<form action="{{route('pharmacy.customer.update', $customer->id)}}" method="POST">
				@csrf
				@method('PUT')
				<div class="form-row">
					
					<div class="form-group col-md-3">
						<label for="type-name">Customer Name</label> <span class="text-danger">*</span>
						<input type="text" name="customer" class="form-control form-control-sm" placeholder="Enter Customer Name" value="{{$customer->name}}">
					</div>

					<div class="form-group col-md-3">
						<label for="type-name">Phone</label> <span class="text-danger">*</span>
						<input type="text" name="phone" class="form-control form-control-sm" placeholder="Enter Phone Number" value="{{$customer->phone}}">
					</div>
					<div class="form-group col-md-4">
						<label for="type-name">Address</label> <span class="text-danger">*</span>
						<input type="text" name="address" class="form-control form-control-sm" placeholder="Enter Address" value="{{$customer->address}}">
					</div>

			        <div class="form-check form-check-inline">
			          <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" {{$customer->status == 1 ? 'checked':''}}>
			          <label class="form-check-label" for="inlineRadio1">Active</label>
			        </div>
			        <div class="form-check form-check-inline">
			          <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0"{{$customer->status == 0 ? 'checked':''}}>
			          <label class="form-check-label" for="inlineRadio2">Deactive</label>
			        </div>
					<div class="form-group col-md-12 mb-3 text-right">
			        	<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-refresh"></i> Update</button>
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