@extends('layouts.app')
@section('title','Add Patient')

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
            <a href="{{$auth == 'Agent' ? route('agent.patient.index') : route('doctor.patient.index')}}" class="btn btn-padding btn-sm btn-success"><i class="fa fa-list"></i> All Patient</a>
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
			<form action="{{$auth == 'Agent' ? route('agent.patient.store') : route('doctor.patient.store')}}" method="POST" enctype="multipart/form-data">
				@csrf
				@if($appoint)
				<input type="hidden" name="online_appoint" value="{{$appoint->id}}" >
				@endif
				<div class="form-row">
					<div class="form-group col-md-7">
						<label for="patient-name">Name</label> <span class="text-danger">*</span>
						<input type="text" maxlength="20" name="name" class="form-control form-control-sm" value="{{$appoint->name}}" placeholder="Full Name" id="patient-name" required>
					</div>
					<div class="form-group col-md-5">
						<label for="dob">Date of Birth</label> <span class="text-danger">*</span>
						<input type="text" autocomplete="off" id="dob" name="age" class="form-control form-control-sm" value="{{$appoint->dob}}" placeholder="Enter Date of Birth" required>
					</div>
					<div class="form-group col-md-3">
						<label for="gender">Gender</label> <span class="text-danger">*</span>
						<select class="form-control form-control-sm" name="gender" id="gender" required>
							<option selected="false" disabled>Select Gender</option>
							<option value="0" {{$appoint->sex == '0' ? 'selected':''}}>Male</option>
							<option value="1" {{$appoint->sex == '1' ? 'selected':''}}>Female</option>
							<option value="2" {{$appoint->sex == '2' ? 'selected':''}}>Other</option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="gender">Marital Status</label>
						<select class="form-control form-control-sm" name="marital_status" id="marital_status" required>
							<option selected="false" disabled>Select Marital Status</option>
							<option value="0" {{$appoint->marital_status == '0' ? 'selected':''}}>Single</option>
							<option value="1" {{$appoint->marital_status == '1' ? 'selected':''}}>Married</option>
							<option value="2" {{$appoint->marital_status == '2' ? 'selected':''}}>Seperated</option>
						</select>
					</div>
					<!--
					<div class="form-group col-md-12">
						<label for="exampleFormControlTextarea1">Address</label> <span class="text-danger">*</span>
						<textarea name="address" class="form-control" cols="10" rows="3"></textarea>
					</div> -->
					<div class="form-group col-md-6" id="other_width">
						<label for="exampleFormControlTextarea1">Address</label> <span class="text-danger">*</span>
						<input type="text" name="address" id="address_id" class="form-control form-control-sm">
					</div>

					<div class="form-group col-md-6">
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="phone">Phone</label> <span class="text-danger">*</span>
								<input type="text" name="phone" placeholder="Phone" class="form-control form-control-sm" value="{{$appoint->phone}}" id="phone" minlength="11" maxlength="11" required>
							</div>
							<div class="form-group col-md-12">
								<label for="blood_group">Blood Group</label>
								<select class="form-control form-control-sm" name="blood_group" id="blood_group">
									<option selected="false" disabled>Select Blood Group</option>
									<option value="A+">A+</option>
									<option value="A-">A-</option>
									<option value="B+">B+</option>
									<option value="B-">B-</option>
									<option value="O+">O+</option>
									<option value="O-">O-</option>
									<option value="AB+">AB+</option>
									<option value="AB-">AB-</option>
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
		    							<img src="" alt="" id="photo">
									</div>
								</div>
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

<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
<script>
	$(function(){
		$("#address_id").autocomplete({
			source: function(request, response){
				$.ajax({
					url: '{{route("doctor.loadAddress")}}',
					type: 'POST',
					dataType: 'JSON',
					data: {search: request.term, _token: '{{csrf_token()}}'},
					success: function(res){
						response(res);
					}
				})
				.fail(function() {
					Swal.fire("Sorry! Something Wrong");
				});
			},
	        select: function (event, ui) {
	        	console.log('Ui');
	        	console.log(ui);
	           $('#address_id').val(ui.item.label); // display the selected text
	           // $('#employeeid').val(ui.item.value); // save selected id to input
	           return false;
	        }
		});
	})

	$("#ecoh_id").focusout(function(){
		var ecoh_id = $(this).val();
		$.ajax({
			url : "{{route('agent.check_ecoh_id')}}",
			method: "POST",
			dataType: "JSON",
			data: {ecoh_id:ecoh_id, _token:"{{csrf_token()}}"},
			success: function(data){
				if (data == 'exist') {
					$("#exist").html('<span class="text-danger">ECOH ID already exist!');
				}else{
					$("#exist").html('<span class="text-success">Great!');
				}
			}
		})
	});
</script>
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
	$("#other").change(function(){
		var address = $(this).val();
		if(address == 'Others'){
			$("#other_width").removeClass('col-md-6');
			$("#other_width").addClass('col-md-3');
			$("#other_address").removeClass('d-none');
			$("#other_address_required").attr('required');
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
