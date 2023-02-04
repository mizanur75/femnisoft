@extends('layouts.app')
@section('title','Edit Service')

@push('css')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush


@section('content')
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
            <a href="{{route('doctor.web-service.index')}}" class="btn btn-padding btn-sm btn-success"><i class="fa fa-list"></i> All Blogs</a>
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
			<form action="{{route('doctor.web-service.update', $service->id)}}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="form-row">
                    {{--<div class="form-group col-md-12" id="other_width">--}}
                        {{--<label for="category_id">Category</label> <span class="text-danger">*</span>--}}
                        {{--<select name="category_id" class="form-control" id="category_id">--}}
                            {{--<option selected="false" disabled>--- Select Category ---</option>--}}
                            {{--@foreach($categories as $category)--}}
                                {{--<option value="{{$category->id}}" {{$service->category_id == $category->id ? 'selected':''}}>{{$category->name}}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}
					<div class="form-group col-md-12">
						<label for="patient-name">Title</label> <span class="text-danger">*</span>
						<input type="text" name="title" class="form-control form-control-sm" placeholder="Title" value="{{$service->title}}" required>
					</div>
					<div class="form-group col-md-12">
						<label for="patient-name">Sub Title</label> <span class="text-danger">*</span>
						<input type="text" name="sub_title" class="form-control form-control-sm" placeholder="sub title" value="{{$service->sub_title}}" required>
					</div>

                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Description</label> <span class="text-danger">*</span>
                        <textarea name="description" id="nic-edit" class="form-control" cols="10" rows="3">{!! $service->description !!}</textarea>
                    </div>

                    <div class="form-group col-md-12" id="uploadImage">
                        <input type="file" name="photo">
                        <img src="{{asset('assets/images/services/'.$service->photo)}}" height="200" width="240" alt="" id="photo">
                    </div>


                    <div class="form-group col-md-12">
                        <label for="exampleFormControlTextarea1">Description 2</label> <span class="text-danger">*</span>
                        <textarea name="details" id="nic-edit2" class="form-control" cols="10" rows="3">{!! $service->details !!}</textarea>
                    </div>

                    <div class="form-group col-md-12" id="uploadImage">
                        <input type="file" name="image2">
                        <img src="{{asset('assets/images/image2/'.$service->image2)}}" height="200" width="240" alt="" id="photo">
                    </div>

					<div class="form-check col-md-12 mb-2">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="ex-check-2" name="status" value="1"  required {{$service->status == 1 ? 'checked':''}}>
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
    <script src="{{asset('assets/js/nicEdit.js')}}"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(function() { new nicEditor().panelInstance('nic-edit'); });
    </script>
    <script type="text/javascript">
        bkLib.onDomLoaded(function() { new nicEditor().panelInstance('nic-edit2'); });
    </script>
@endpush
