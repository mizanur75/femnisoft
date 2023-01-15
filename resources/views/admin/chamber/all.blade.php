@extends('layouts.app')
@section('title','All Chamber')

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
<div class="row">
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right">
			<button type="button" class="btn btn-padding btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
				<i class="fa fa-plus"></i> Add Chamber
			</button>
        </div>
    </div>
	@if($errors->any())
	<div class="col-md-12">
		@foreach($errors->all() as $error)
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>{{ $error }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		@endforeach
    </div>
	@endif
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
			<div class="table-responsive mb-3">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Chamber Logo</th>
							<th>Chamber Name</th>
							<th>Address</th>
							<th>ZIP/Post Code</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($chambers as $chamber)
						<tr class="text-center">
							<td>{{$loop->index +1}}</td>
							<td><img src="{{asset('images/chamber/'.$chamber->logo)}}" style="height: 40px;"></td>
							<td>{{$chamber->name}}</td>
							<td>{{$chamber->address}}</td>
							<td>{{$chamber->post_code}}</td>
							<td>
								<a href="{{route('admin.chamber.edit',$chamber->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- /Widget Item -->
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Input Chamber Info</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<form action="{{route('admin.chamber.store')}}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="modal-body">
	      	<label for="">Name</label>
	      	<input type="text" name="name" class="form-control form-control-sm" placeholder="Chamber Name">
	      	<label for="">Address</label>
	      	<input type="text" name="address" class="form-control form-control-sm" placeholder="Address">
	      	<label for="">ZIP Code</label>
	      	<input type="text" name="post_code" class="form-control form-control-sm" placeholder="ZIP/Post Code">
	      	<label for="">Chamber Logo</label>
	      	<input type="file" name="logo" class="form-control form-control-sm">
	      	<div for="">Status</div>
	        <div class="form-check form-check-inline">
	          <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1">
	          <label class="form-check-label" for="inlineRadio1">Active</label>
	        </div>
	        <div class="form-check form-check-inline">
	          <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
	          <label class="form-check-label" for="inlineRadio2">Deactive</label>
	        </div>
	      </div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-padding btn-primary"><i class="fa fa-plus"></i> Add</button>
		</div>
		</form>
    </div>
  </div>
</div>
@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$("#tableId").dataTable();
</script>
@endpush