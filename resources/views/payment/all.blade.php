@extends('layouts.app')
@section('title','All Payment')

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
			<div class="table-responsive">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>ID</th>
							<th>Tran. ID</th>
							<th>Name</th>
							<th>Address</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($payments as $payment)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$payment->id}}</td>
							<td>{{$payment->transaction_id}}</td>
							<td>{{$payment->user->name}}</td>
							<td>{{$payment->address}}</td>
							<td>{{$payment->user->email}}</td>
							<td>{{$payment->user->phone}}</td>
							<td>{{$payment->amount}}</td>
							<td class="text-center">{{date('d M Y', strtotime($payment->created_at))}}</td>
							<td class="text-center">
								@if($payment->status == 'Complete')
									<button type="button" class="btn btn-padding btn-sm btn-primary">Complete</a>
								@elseif($payment->status == 'Processing')
									<button type="button" class="btn btn-padding btn-sm btn-info">Processing</a>
								@else
									<button type="button" class="btn btn-padding btn-sm btn-danger">Failed</a>
								@endif
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