@extends('layouts.app')
@section('title','Stocks')

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
				<table id="tableId" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#SL</th>
							<th>C. Name</th>
							<th>G. Name</th>
							<th>M. Name</th>
							<th class="text-center">UoM</th>
							<th class="text-center">TP Rate</th>
							<th class="text-center">W. Sale</th>
							<th class="text-center">MRP</th>
							<th class="text-center">Exp. Date</th>
							<th class="text-center">Qty</th>
						</tr>
					</thead>
					<tbody>
						@foreach($stocks as $stock)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$stock->tpname}}</td>
							<td>{{$stock->gname}}</td>
							<td>{{$stock->medname}}</td>
							<td class="text-center">{{$stock->mesname}}</td>
							<td class="text-center">{{$stock->tp}}</td>
							<td class="text-center">{{$stock->wholesale}}</td>
							<td class="text-center">{{$stock->mrp}}</td>
							<td class="text-center font-weight-bold" id="class">
								@if($stock->expire_date == !null)
								@php($date = date('Y m d h:m:s', strtotime($stock->expire_date)))
								<span id="demo{{$stock->id}}"></span>
									<script>
									// Set the date we're counting down to
									var countDownDate{{$stock->id}} = new Date("{{$date}}").getTime();

									// Update the count down every 1 second
									var x = setInterval(function() {

									  // Get today's date and time
									  var now = new Date().getTime();
									    
									  // Find the distance between now and the count down date
									  var distance = countDownDate{{$stock->id}} - now;
									    
									  // Time calculations for days, hours, minutes and seconds
									  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
									  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
									  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
									  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
									    
									  // Output the result in an element with id="demo"
									  document.getElementById("demo{{$stock->id}}").innerHTML = days + "D " + hours + "H "
									  + minutes + "M " + seconds + "S ";

									  if (days < 30 && days > 0) {
									  	document.getElementById("demo{{$stock->id}}").classList.add("color-yellow");
									  }
									    
									  // If the count down is over, write some text 
									  if (distance < 0) {
									    clearInterval(x);
									    document.getElementById("demo{{$stock->id}}").innerHTML = "<span style='color:red;'>EXPIRED</span>";
									  }
									}, 1000);
									</script>
								@endif
							</td>
							<td class="text-center">
								@if($stock->qty <= 10 && $stock->qty >= 1)
								<button class="btn btn-padding btn-sm btn-warning">{{$stock->qty}}</button>
								@elseif($stock->qty > 10)
								<button class="btn btn-padding btn-sm btn-success">{{$stock->qty}}</button>
								@else
								<button class="btn btn-padding btn-sm btn-danger">Out of Stock</button>
								@endif
							</td>
							{{-- <td class="text-center">
								@if($stock->piece_qty <= (10 * $stock->mesqty) && $stock->piece_qty >= (1*$stock->mesqty))
								<button class="btn btn-padding btn-sm btn-warning">{{$stock->piece_qty}}</button>
								@elseif($stock->piece_qty > (10 * $stock->mesqty))
								<button class="btn btn-padding btn-sm btn-success">{{$stock->piece_qty}}</button>
								@else
								<button class="btn btn-padding btn-sm btn-danger">Out of Stock</button>
								@endif
							</td> --}}
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