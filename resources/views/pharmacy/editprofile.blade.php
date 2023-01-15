@extends('layouts.app')
@section('title','Edit '.$pharmacy->name.' profile')

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
			
			<form action="{{route('pharmacy.profile.update',$pharmacy->user_id)}}" method="POST" enctype="multipart/form-data">
				@csrf
                @method('PUT')
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="doctor Title">Pharmacy Name</label>
						<input type="text" name="name" class="form-control form-control-sm" value="{{$pharmacy->name}}" placeholder="Enter Your Pharmacy Name">
					</div>
					<div class="form-group col-md-6">
						<label for="age">Slogan</label>
						<input type="text" name="slogan" class="form-control form-control-sm" value="{{$pharmacy->slogan}}" placeholder="Enter Your Pharmacy Slogan">
					</div>
					<div class="form-group col-md-6">
						<label for="education">Phone</label>
						<input type="text" name="phone" class="form-control form-control-sm" id="phone" value="{{$pharmacy->phone}}" placeholder="Enter Your Pharmacy Phone Number">
					</div>
					<div class="form-group col-md-6">
						<label for="address">Address</label>
						<input type="text" name="address" class="form-control form-control-sm" id="address" value="{{$pharmacy->address}}" placeholder="Enter Your Pharmacy Address">
					</div>
					<div class="form-group col-md-3">
						<label for="open_time">Open Time</label>
						<input type="text" name="open_time" class="form-control form-control-sm" id="open_time" value="{{$pharmacy->open_time}}" placeholder="Enter Your Pharmacy Open Time">
					</div>
					<div class="form-group col-md-3">
						<label for="file">Logo</label>
						<input type="file" class="form-control form-control-sm select-file" name="logo">
						<img src="{{asset('images/pharmacy/'.$pharmacy->logo)}}" height="50" alt="">
					</div>
					<div class="form-group col-md-3">
						<label for="tax">Tax (%)</label>
						<input type="text" name="tax" class="form-control form-control-sm" id="tax" value="{{$pharmacy->tax}}" placeholder="Enter Tax Rate(%)">
					</div>
					<div class="form-group col-md-3">
						<label for="discount">Discount (%)</label>
						<input type="text" name="discount" class="form-control form-control-sm" id="discount" value="{{$pharmacy->discount}}" placeholder="Enter Discount (%)">
					</div>
														
					<div class="form-check col-md-6 mb-2">
						<div class="text-left">
							<div class="custom-control">
								<input class="_custom-control-input" type="radio" id="ex-check-1" name="status" {{$pharmacy->status == 1?'checked':''}} value="1">
								<label class="custom-control-label" for="ex-check-1">Active</label>

								<input class="_custom-control-input" type="radio" id="ex-check-2" name="status" {{$pharmacy->status == 0?'checked':''}} value="0">
								<label class="custom-control-label" for="ex-check-2">Deactive</label>
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