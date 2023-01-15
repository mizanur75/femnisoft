@extends('layouts.app')
@section('title','All Customer')

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<style>
	.bold{
		font-weight: bold;
	}

	select.form-control:not([size]):not([multiple]) {
	    height: 1.8rem;
	    width: 3rem;
	}
</style>
@endpush


@section('content')
<div class="row">
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-padding btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">
			  <i class="fa fa-plus"></i> Add New
			</button>
        </div>
    </div>
    @if($errors->any())
	    @foreach($errors->all() as $error)
	    <div class="col-md-12">
	    	<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>{{ $error }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		</div>
	    @endforeach
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
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>ID</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Address</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($customers as $customer)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td class="text-center">{{$customer->id}}</td>
							<td class="text-center">{{$customer->name}}</td>
							<td class="text-center">{{$customer->phone}}</td>
							<td class="text-center">{{$customer->address}}</td>
							<td class="text-center">
							@if($customer->status == 0)
							<button type="button" class="btn btn-padding btn-sm btn-warning"><i class="fa fa-ban"></i> Deactive</button>
							@else
							<button type="button" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-check-circle"></i> Active</button>
							@endif
							</td>
							<td class="text-center">
								<a href="{{route('pharmacy.customer.edit',\Crypt::encrypt($customer->id))}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>
								<a href="{{route('pharmacy.customer.show',\Crypt::encrypt($customer->id))}}" class="btn btn-padding btn-sm btn-info" target="_blank"><i class="fa fa-eye"></i></a>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title bold" id="exampleModalLabel">Input Customer Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action=" {{ route('pharmacy.customer.store') }}" method="POST">
	      @csrf
	      <div class="modal-body">
	      	<label for="" class="bold">Name</label>
	      	<input type="text" name="customer" class="form-control form-control-sm" placeholder="Input Customer Name">
	      	<div class="mt-2">
	      	<label for="" class="bold">Phone</label>
	      		<input type="text" name="phone" class="form-control form-control-sm" placeholder="Input Customer Phone Number">
	      	</div>
	      	<div class="mt-2">
	      	<label for="" class="bold">Address</label>
	      		<input type="text" name="address" class="form-control form-control-sm" placeholder="Input Customer Address">
	      	</div>
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
	        <button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-plus"></i> Add</button>
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