@extends('layouts.app')
@section('title','Edit Blog')

@push('css')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush


@section('content')
@php
$edit = Auth::user()->role->name == 'Doctor' ? route('doctor.blog.store') : route('agent.blog.store');
$update = Auth::user()->role->name == 'Doctor' ? route('doctor.blog.update', $blog->id) : route('agent.blog.update', $blog->id);
$all = Auth::user()->role->name == 'Doctor' ? route('doctor.blog.index') : route('agent.blog.index');
@endphp
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
            <a href="{{$all}}" class="btn btn-padding btn-sm btn-success"><i class="fa fa-list"></i> All Blog</a>
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
					<div class="form-group col-md-12">
						<label for="blog-name">Title</label> <span class="text-danger">*</span>
						<input type="text" name="title" class="form-control form-control-sm" placeholder="Title" value="{{$blog->title}}" required>
					</div>
					<div class="form-group col-md-12">
						<label for="exampleFormControlTextarea1">Description</label> <span class="text-danger">*</span>
						<textarea name="description" class="form-control" cols="10" rows="5">{!!$blog->description!!}</textarea>
					</div>

					<div class="form-check col-md-6 mb-2">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="radio" id="ex-check-1" name="status" {{$blog->status == 1 ? 'checked':''}} value="1">
								<label class="custom-control-label" for="ex-check-1">Active</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="radio" id="ex-check-0" name="status" value="0" {{$blog->status == 0 ? 'checked':''}}>
								<label class="custom-control-label" for="ex-check-0">Deactive</label>
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
