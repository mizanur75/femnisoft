@extends('layouts.app')
@section('title','Create New Blog')

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
            <a href="{{$auth == 'Agent' ? route('agent.blog.index') : route('doctor.blog.index')}}" class="btn btn-padding btn-sm btn-success"><i class="fa fa-list"></i> All Blog</a>
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
			<form action="{{$auth == 'Agent' ? route('agent.blog.store') : route('doctor.blog.store')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="form-row">
					<div class="form-group col-md-12">
						<label for="blog-name">Title</label> <span class="text-danger">*</span>
						<input type="text" name="title" class="form-control form-control-sm" placeholder="Full Name" id="blog-name" required>
					</div>
					
					<div class="form-group col-md-12">
						<label for="exampleFormControlTextarea1">Description</label> <span class="text-danger">*</span>
						<textarea name="description" class="form-control" cols="10" rows="5"></textarea>
					</div> 
					<div class="form-check col-md-6">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="radio" id="ex-check-1" name="status" value="1">
								<label class="custom-control-label" for="ex-check-1">Active</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="radio" id="ex-check-0" name="status" value="0">
								<label class="custom-control-label" for="ex-check-0">Deactive</label>
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
