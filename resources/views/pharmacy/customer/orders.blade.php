@extends('layouts.app')
@section('title','All Orders '.$customer->name)

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
			<div class="row">
				<div class="col-sm-4 col-md-4 col-lg-4">
					<form action="{{ route('pharmacy.sales_pay') }}" method="post" class="form">
						@csrf
						<div class="row">
							<div class="col-sm4 col-md-4 col-lg-4">
								<input type="text" name="code" class="form-control-sm w-100" placeholder="Code">
							</div>
							<div class="col-sm4 col-md-4 col-lg-4">
								<input type="text" name="pay_amount" class="form-control-sm w-100" placeholder="Due Amount">
							</div>
							<div class="col-sm2 col-md-2 col-lg-2">
								<button type="submit" class="btn btn-padding btn-block btn-sm btn-primary">Pay</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-sm-8 col-md-8 col-lg-8">
					<a href="{{route('pharmacy.sale.index')}}" class="brn btn-sm btn-primary float-right btn-padding"><i class="fa fa-list"></i> All Invoice</a>
				</div>
			</div>
			<div class="table-responsive mb-3">
				<table id="tableId" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>O. ID</th>
							<th>Code</th>
							<th>T. Amount</th>
							<th>G. Amount</th>
							<th>Due Amount</th>
							<th>Comments</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($orders as $order)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$order->id}}</td>
							<td>{{$order->code}}</td>
							<td class="text-center">{{$order->total_amount}}</td>
							<td class="text-center {{$order->given_amount < $order->total_amount ? 'color-red font-weight-bold':''}}">{{$order->given_amount}}</td>
							<td class="text-center {{$order->total_amount - $order->given_amount > 0 ? 'color-red font-weight-bold':''}}">
								@if($order->total_amount - $order->given_amount > 0)
								{{$order->total_amount - $order->given_amount}}
								@else
									<span class=" font-weight-bold color-green"> No Due</span>
								@endif
							</td>
							<td class="text-center">
								{{$order->comments}}
							</td>
							<td class="text-center">
								{{date("d M Y", strtotime($order->created_at))}}
							</td>
							<td class="text-center">
								<a href="{{route('pharmacy.customerinvoicedetails',$order->id)}}" class="btn btn-padding btn-sm btn-info"><i class="fa fa-eye"></i></a>
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
        <h5 class="modal-title bold" id="exampleModalLabel">Input order Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action=" {{ route('pharmacy.customer.store') }}" method="POST">
	      @csrf
	      <div class="modal-body">
	      	<label for="" class="bold">Name</label>
	      	<input type="text" name="order" class="form-control form-control-sm" placeholder="Input order Name">
	      	<div class="mt-2">
	      	<label for="" class="bold">Phone</label>
	      		<input type="text" name="phone" class="form-control form-control-sm" placeholder="Input order Phone Number">
	      	</div>
	      	<div class="mt-2">
	      	<label for="" class="bold">Address</label>
	      		<input type="text" name="address" class="form-control form-control-sm" placeholder="Input order Address">
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