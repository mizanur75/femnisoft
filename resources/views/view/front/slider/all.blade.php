@extends('layouts.app')
@section('title',' All Blog')

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
		            <a href="{{$auth == 'Agent' ? route('agent.blog.create') : route('doctor.blog.create')}}" class="btn btn-padding btn-sm btn-success"><i class="fa fa-plus"></i> Add New</a>
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
						@if($blogs)
						@foreach($blogs as $blog)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{$blog->title}}</td>
							<td>{{$blog->description}}</td>
							<td class="text-center">
								@if($blog->status == 0)
								<a href="javascript:void(0)" class="btn btn-padding btn-sm btn-danger"><i class="fa fa-times"></i> Deactive</a>
								@else
								<a href="javascript:void(0)" class="btn btn-padding btn-sm btn-success"><i class="fa fa-check"></i> Active</a>
								@endif
							</td>
							<td class="text-center">{{date('d M Y', strtotime($blog->created_at))}}</td>
							<td class="text-center">
								<a href="{{route('doctor.blog.show', $blog->id)}}" class="btn btn-padding btn-sm btn-info" target="_blank"><i class="fa fa-eye"></i></a>
        						<a href="{{route('doctor.blog.edit', $blog->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i>
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
<script>
        $("#tableId").dataTable();
</script>
@endpush
