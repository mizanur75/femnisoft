@extends('layouts.app')
@section('title','Edit '.$doctor->name.' profile')

@push('css')
	<style>
		.form-control {
		    border-color: #8c8282;
		}
	</style>
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
			
			<form action="{{route('doctor.profile.update',$doctor->user_id)}}" method="POST" enctype="multipart/form-data">
				@csrf
                @method('PUT')
				<div class="form-row">
					<div class="form-group col-md-3">
						<label for="doctor Title">Title</label>
						<input type="text" name="title" value="{{$doctor->title}}" class="form-control form-control-sm">
					</div>
					<div class="form-group col-md-3">
						<label for="age">Speciality</label>
						<input type="text" name="specialist" value="{{$doctor->specialist}}" class="form-control form-control-sm">
					</div>
					<div class="form-group col-md-3">
						<label for="education">Education</label>
						<input type="text" name="education" value="{{$doctor->education}}" class="form-control form-control-sm" id="education">
					</div>
					<div class="form-group col-md-3">
						<label for="regi_no">BM&DC Reg. No.</label>
						<input type="text" name="regi_no" value="{{$doctor->regi_no}}" class="form-control form-control-sm" id="regi_no">
					</div>
					<div class="form-group col-md-2">
						<label for="experience">Experience</label>
						<input type="experience" name="experience" value="{{$doctor->experience}}" class="form-control form-control-sm" id="experience">
					</div>
					<div class="form-group col-md-5">
						<label for="work_station">Work Station</label>
						<select name="work_station" class="form-control form-control-sm" id="work_station">
							<option selected="false" disabled>Select Work Station</option>
							@foreach($chambers as $chamber)
							<option value="{{$chamber->id}}" {{$chamber->id == $doctor->current_work_station ? 'selected':''}}>
								{{$chamber->name}}, {{$chamber->address}}-{{$chamber->post_code}}
							</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-5">
						<label for="chamber_id">Chamber</label>
						<select name="chamber_id" class="form-control form-control-sm" id="chamber_id">
							<option selected="false" disabled>Select Chamber</option>
							@foreach($chambers as $chamber)
							<option value="{{$chamber->id}}" {{$chamber->id == $doctor->chamber_id ? 'selected':''}}>{{$chamber->name}}, {{$chamber->address}}-{{$chamber->post_code}}</option>
							@endforeach
						</select>
					</div>
					<!-- <div class="form-group col-md-6">
						<label for="work_station">Work Station</label>
						<input type="work_station" name="work_station" value="{{$doctor->current_work_station}}" class="form-control form-control-sm" id="work_station">
					</div> -->
					<div class="form-group col-md-6">
						<label for="file">Photo</label>
						<input type="file" class="form-control form-control-sm" name="image">
						<img src="{{asset('images/doctor/'.$doctor->image)}}" height="50" alt="">
					</div>
					<div class="form-group col-md-6">
						<label for="file">Signature</label>
						<input type="file" class="form-control form-control-sm" name="signature">
						<img src="{{asset('images/signature/'.$doctor->signature)}}" height="50" alt="">
					</div>
														
					<div class="form-check col-md-6 mb-2">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="ex-check-2" required>
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