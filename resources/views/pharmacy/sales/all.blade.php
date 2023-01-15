@extends('layouts.app')
@section('title','All Order Invoice')

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
					<a href="{{route('pharmacy.sale.create')}}" class="brn btn-sm btn-primary float-right btn-padding"><i class="fa fa-plus-circle"></i> Create Invoice</a>
				</div>
			</div>
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>O. ID</th>
							<th>Code</th>
							<th>Name</th>
							<th>Phone</th>
							<th>T. Amount</th>
							<th>G. Amount</th>
							<th>Due Amount</th>
							<th>Comments</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sales as $sale)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$sale->id}}</td>
							<td>{{$sale->code}}</td>
							<td>{{$sale->cname}}</td>
							<td>{{$sale->cphone}}</td>
							<td class="text-center">{{$sale->total_amount}}</td>
							<td class="text-center {{$sale->given_amount < $sale->total_amount ? 'color-red font-weight-bold':''}}">{{$sale->given_amount}}</td>
							<td class="text-center {{$sale->total_amount - $sale->given_amount > 0 ? 'color-red font-weight-bold':''}}">
								@if($sale->total_amount - $sale->given_amount > 0)
								{{$sale->total_amount - $sale->given_amount}}
								@else
									<span class=" font-weight-bold color-green"> No Due</span>
								@endif
							</td>
							<td class="text-center">
								{{$sale->comments}}
							</td>
							<td class="text-center">
								{{date("d M Y", strtotime($sale->created_at))}}
							</td>
							<td class="text-center">
								<a href="{{ route('pharmacy.sale.show', \Crypt::encrypt($sale->id)) }}" target="_blank" class="btn btn-padding btn-sm btn-info"><i class="fa fa-eye"></i> </a>
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
@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$("#tableId").dataTable();
</script>
@endpush