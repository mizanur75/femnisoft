@extends('layouts.app')
@section('title','Edit Patient')

@push('css')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush


@section('content')
@php
$edit = Auth::user()->role->name == 'Doctor' ? route('doctor.patient-info.store') : route('agent.patient-info.store');
$update = Auth::user()->role->name == 'Doctor' ? route('doctor.patient.update', $patient->id) : route('agent.patient.update', $patient->id);
$all = Auth::user()->role->name == 'Doctor' ? route('doctor.patient.index') : route('agent.patient.index');
@endphp
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
            <a href="{{$all}}" class="btn btn-padding btn-sm btn-success"><i class="fa fa-list"></i> All Patient</a>
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
			<form action="{{$update}}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="form-row">
					<div class="form-group col-md-3">
						<label for="ecoh_id">ECOH ID</label> <span class="text-danger">*</span>
						<input type="text" minlength="5" maxlength="5" name="ecoh_id" class="form-control form-control-sm" placeholder="Enter Previous ID" id="ecoh_id" value="{{$patient->centre_patient_id}}" required readonly>
					</div>
					<div class="form-group col-md-6">
						<label for="patient-name">Name</label> <span class="text-danger">*</span>
						<input type="text" maxlength="20" name="name" class="form-control form-control-sm" placeholder="Full Name" value="{{$patient->name}}" required>
					</div>
					<div class="form-group col-md-3">
						<label for="dob">Date of Birth</label> <span class="text-danger">*</span>
						<input type="text" id="dob" name="age" class="form-control form-control-sm" autocomplete="off" value="{{$patient->age}}" placeholder="Enter DoB" required>
					</div>
					<div class="form-group col-md-3">
						<label for="gender">Sex</label> <span class="text-danger">*</span>
						<select class="form-control form-control-sm" name="gender" id="gender" required>
							<option selected="false" disabled>Please Select Gender</option>
							<option value="0" {{$patient->gender == 0 ? 'selected':''}}>Male</option>
							<option value="1" {{$patient->gender == 1 ? 'selected':''}}>Female</option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="marital_status">Marital Status</label>
						<select class="form-control form-control-sm" name="marital_status" id="marital_status">
							<option selected="false" disabled>Select Marital Status</option>
							<option value="0" {{$patient->marital_status == 0 ? 'selected':''}}>Single</option>
							<option value="1" {{$patient->marital_status == 1 ? 'selected':''}}>Married</option>
						</select>
					</div>
					<div class="form-group col-md-6" id="other_width">
						<label for="exampleFormControlTextarea1">Address</label> <span class="text-danger">*</span>
						<select name="address" class="form-control" id="_other">
							@foreach($addresses as $address)
							<option value="{{$address->id}}" {{$patient->address_id == $address->id ? 'selected':''}}>{{$address->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-3 d-none" id="other_address">
						<label for="other_address">Other Address</label> <span class="text-danger">*</span>
						<input type="text" name="other_address" id="other_address_required" class="form-control form-control-sm" placeholder="Enter Address" value="{{$patient->address}}">
					</div>

					<div class="form-group col-md-6">
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="phone">Phone</label> <span class="text-danger">*</span>
								<input type="text" name="phone" placeholder="Phone" class="form-control form-control-sm"  value="{{$patient->phone}}" required>
							</div>
							<div class="form-group col-md-12">
								<label for="blood_group">Blood Group</label>
								<select class="form-control form-control-sm" name="blood_group" id="blood_group">
									<option selected="false" disabled>Please Select Blood Group</option>
									<option value="A+" {{$patient->blood_group == 'A+' ? 'selected':''}}>A+</option>
									<option value="A-" {{$patient->blood_group == 'A-' ? 'selected':''}}>A-</option>
									<option value="B+" {{$patient->blood_group == 'B+' ? 'selected':''}}>B+</option>
									<option value="B-" {{$patient->blood_group == 'B-' ? 'selected':''}}>B-</option>
									<option value="O+" {{$patient->blood_group == 'O+' ? 'selected':''}}>O+</option>
									<option value="O-" {{$patient->blood_group == 'O-' ? 'selected':''}}>O-</option>
									<option value="AB+" {{$patient->blood_group == 'AB+' ? 'selected':''}}>AB+</option>
									<option value="AB-" {{$patient->blood_group == 'AB-' ? 'selected':''}}>AB-</option>
								</select>
							</div>
						</div>
					</div>


					<div class="form-group col-md-6">
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="selectOptionForwebcamImage">Webcam</label>
								<input type="radio" name="selectOptionForUploadImage" id="selectOptionForwebcamImage">
								<label for="selectOptionForUploadImage">Upload</label>
								<input type="radio" name="selectOptionForUploadImage" id="selectOptionForUploadImage">
							</div>
							<div class="form-group col-md-1">
							</div>

							<div class="form-group col-md-11" id="uploadImage">
								<input type="file" name="uploadImage">
							</div>

							<div class="form-group col-md-10" id="webcamImage">
								<div class="row">
									<div class="com-md-6">
										<input type="hidden" id="image" name="webcamImage">
										<label>Webcam</label><br>
										<video id="video" class="border" width="240" height="200" playsinline autoplay></video>
										<br>
										<button type="button" class="btn btn-sm btn-padding btn-success" id="take" onclick="takePicture()">Take Picture</button>
										<button type="button" class="btn btn-sm btn-padding btn-danger float-right" id="snap">Capture</button>
									</div>
									<div class="form-group col-md-5">
										<label>Picture</label>
										<canvas id="canvas" width="240" height="200" style="display:none;" class="border"></canvas>
		    							<img src="{{asset('images/patient/'.$patient->image)}}" height="200" width="240" alt="" id="photo">
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-check col-md-6 mb-2">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="ex-check-2" name="status" value="1"  required {{$patient->status == 1 ? 'checked':''}}>
								<label class="custom-control-label" for="ex-check-2">Please Confirm</label>
							</div>
						</div>
					</div>
					<div class="form-group col-md-6 mb-3">
						<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-refresh"></i> Update Now</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
@endsection


@push('scripts')
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>

<script>
	$(function(){
		$("#selectOptionForwebcamImage").attr('checked', true);
		$("#uploadImage").addClass('d-none');
		$("#webcamImage").removeClass('d-none');
	})
	$("#selectOptionForwebcamImage").click(function(){
		$("#webcamImage").removeClass('d-none');
		$("#uploadImage").addClass('d-none');
	});
	$("#selectOptionForUploadImage").click(function(){
		$("#webcamImage").addClass('d-none');
		$("#uploadImage").removeClass('d-none');
	});
</script>
<!-- <script>
	$(function(){
		var editaddress = $("#other").val();
		if(editaddress == 'Others'){
			$("#other_width").removeClass('col-md-6');
			$("#other_width").addClass('col-md-3');
			$("#other_address").removeClass('d-none');
			$("#other_address_required").addAttr('required');
		}else{
			$("#other_width").addClass('col-md-6');
			$("#other_address").addClass('d-none');
			$("#other_address_required").removeAttr('required');
		}
	})
	$("#other").change(function(){
		var address = $(this).val();
		if(address == 'Others'){
			$("#other_width").removeClass('col-md-6');
			$("#other_width").addClass('col-md-3');
			$("#other_address").removeClass('d-none');
			$("#other_address_required").addAttr('required');
		}else{
			$("#other_width").addClass('col-md-6');
			$("#other_address").addClass('d-none');
			$("#other_address_required").removeAttr('required');
		}
	});
</script> -->
<script>
    function takePicture(){
        'use strict';
        const video = document.getElementById('video');
        const snap = document.getElementById('snap');
        const canvas = document.getElementById('canvas');
        const photo = document.getElementById('photo');
        const errorMsgElement = document.getElementById('span#ErrorMsg');

        const constraints = {
            audio: false,
            video:{
                width: 240, height:200
            }
        };

        async function init(){
            try{
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleSuccess(stream);
            }catch(e){
                errorMsgElement.innerHTML = `navigator.getUserMedia.error:${e.toString()}`;
            }
        };


        function handleSuccess(stream){
            window.stream = stream;
            video.srcObject = stream;
        }

        init();

        var context = canvas.getContext('2d');
        snap.addEventListener("click", function(){
            context.drawImage(video, 0, 0, 240, 200);
            photo.setAttribute('src', canvas.toDataURL('image/png'));
            var image = canvas.toDataURL('image/png');
            document.getElementById('image').value = image;
        });
    }

    $( function() {
		$( "#dob" ).datepicker({
			dateFormat: 'dd-mm-yy',
			maxDate: 0,
			changeMonth: true,
    		changeYear: true,
		    minDate: "-100Y",
		    yearRange: "-100:-0"

		});
	} );

</script>
@endpush
