@extends('layouts.app')
@section('title',' All Slider')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
</style>
@endpush


@section('content')
@php($auth = Auth::user()->role->name)
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right">
        	<div class="row">
        		<div class="col-md-1 float-right">
		            <a href="{{$auth == 'Agent' ? route('agent.slider.create') : route('doctor.doctor-sl-create')}}" class="btn btn-padding btn-sm btn-success"><i class="fa fa-plus"></i> Add New</a>
		        </div>
        	</div>
        </div>
    </div>
	<!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endif

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
		
        @if(Session::has('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
			<div class="table-responsive">
				
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead class="text-center">
						<tr>
							<th>#SL</th>
							<th>Title</th>
							<th>Description</th>
							<th>Status</th>
							<th>Create Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($sliders)
						@foreach($sliders as $slider)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{$slider->title}}</td>
							<td>{{$slider->description}}</td>
							<td class="text-center">
								@if($slider->status == 0)
								<a href="javascript:void(0)" class="btn btn-padding btn-sm btn-danger"><i class="fa fa-times"></i> Deactive</a>
								@else
								<a href="javascript:void(0)" class="btn btn-padding btn-sm btn-success"><i class="fa fa-check"></i> Active</a>
								@endif
							</td>
							<td class="text-center">{{date('d M Y', strtotime($slider->created_at))}}</td>
							<td class="text-center">
								<a href="{{route('doctor.slider.show', $slider->id)}}" class="btn btn-padding btn-sm btn-info" target="_blank"><i class="fa fa-eye"></i></a>
        						<a href="{{route('doctor.slider.edit', $slider->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i>
        						</a>
							</td>
						</tr>
						@endforeach
                        @else
                        Sorry! No data found.
                        @endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
		var table = $('#geniustable').DataTable({
			   ordering: false,
               processing: true,
               serverSide: true,
               ajax: '{{ route('doctor.doctor-sl-datatables') }}',
               columns: [
                        { data: 'photo', name: 'photo' , searchable: false, orderable: false},
                        { data: 'title_text', name: 'title_text' },
            			{ data: 'action', searchable: false, orderable: false }

                     ],
                language : {
                	processing: '<img src="{{asset('assets/images/logo-dark.png')}}">'
                }
            });

      	$(function() {
        $(".btn-area").append('<div class="col-sm-4 table-contents">'+
        	'<a class="add-btn" href="{{route('doctor.doctor-sl-create')}}">'+
          '<i class="fas fa-plus"></i> {{ __('Add New Slider') }}'+
          '</a>'+
          '</div>');
      });
@endpush