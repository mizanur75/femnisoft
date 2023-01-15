@extends('layouts.app')
@section('title','All generic')

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
        <div class="widget-area-2 proclinic-box-shadow text-right" style="padding: 5px 18px 0px 0px;">
			<!-- <button class="btn btn-padding btn-sm btn-info"><i class="fa fa-plus"></i> </button> -->
			<button type="button" class="btn btn-padding btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
				<i class="fa fa-plus"></i> Add Generic
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
			<div class="table-responsive mb-3">
				<table id="tableId" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Generic Name</th>
							<th>Description</th>
							<th>Indication</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($generics as $generic)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$generic->name}}</td>
							<td>{{$generic->description}}</td>
							<td>{{$generic->indication}}</td>
							<td class="text-center">
							@if($generic->status == 0)
							<button type="button" class="btn btn-padding btn-sm btn-warning"><i class="fa fa-edit"></i> Deactive</button>
							@else
							<button type="button" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-check-circle"></i> Active</button>
							@endif
							</td>
							<td class="text-center">
								<a href="{{route('admin.generic.edit',$generic->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>
								<form action="{{route('admin.generic.destroy', $generic->id)}}" method="post"
									style="display: inline;"
									onsubmit="return confirm('Are you Sure? Want to delete')">
									@csrf
									@method('DELETE')
									<button class="btn btn-padding btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i>
									</button>
								</form>
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
		<h5 class="modal-title" id="exampleModalLongTitle">Input Generic</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<form action="{{route('admin.generic.store')}}" method="post">
		@csrf
		<div class="modal-body">
			<label for="" class="font-weight-bold">Generic Name</label>
			<input type="text" name="name" class="form-control form-control-sm" placeholder="Generic Name">
			<label for="" class="font-weight-bold">Description</label>
			<input type="text" name="description" class="form-control form-control-sm" placeholder="Generic Description">
			<label for="" class="font-weight-bold">Indication</label>
			<input type="text" name="indication" class="form-control form-control-sm" placeholder="Generic Indication">
			<div for="" class="font-weight-bold">Status</div>
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