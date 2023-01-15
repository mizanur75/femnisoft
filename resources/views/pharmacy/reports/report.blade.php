@extends('layouts.app')
@section('title',$title.' Report')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('fontawesome/css/fontawesome.css')}}"/>
	<style>
		.border-less{
			border-top: 0px;
		}
		.my-card{
		    position:absolute;
		    left:40%;
		    top:-20px;
		    border-radius:50%;
		}
		.blue{
			background-color: #dfdfff;
		}
		.green{
			background-color: #edfded;
		}
		.red{
			background-color: #ffdfdf;
		}
		.info{
			background-color: #c8eff7;
		}
		.yellow{
			background-color: #ffffc1;
		}
	</style>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endif
	</div>
	<div class="col-md-12">
	    <div class="widget-area-2 proclinic-box-shadow color-red">
	    	@php
	    		$totalamount = 0;
	    		$givenamount = 0;
	    		$tcosts = 0;
	    		$buyamount = 0;

	    	@endphp
	    	@foreach ($invoices as $invoice)
	    		@php
	    		$totalamount += $invoice->total_amount;
	    		$givenamount += $invoice->given_amount;
	    		@endphp
	    	@endforeach
	    	@foreach ($reports as $report)
	    		@php
	    			$buyamount += $report->tp * $report->qty;
	    		@endphp
	    	@endforeach
	    	@foreach ($costs as $cost)
	    		@php
	    			$tcosts += $cost->cost_price;
	    		@endphp
	    	@endforeach
	    	@php($nit_profit = $totalamount - $tcosts)
			<div class="row p-2 mb-4">
		        <div class="col-md-3 mb-4">
		            <div class="card border-primary mx-sm-1 p-3 blue">
		                <div class="card border-primary shadow text-primary p-3 my-card" ><i class="fa fa-file-alt"></i></div>
		                <div class="text-primary text-center mt-3"><h4>Invoices</h4></div>
		                <div class="text-primary text-center mt-2"><h3>{{$invoices->count()}}</h3></div>
		            </div>
		        </div>
		        <div class="col-md-3">
		            <div class="card border-info mx-sm-1 p-3 info">
		                <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-money" aria-hidden="true"></span></div>
		                <div class="text-info text-center mt-3"><h4>Total Sales Amount</h4></div>
		                <div class="text-info text-center mt-2"><h3>{{number_format($totalamount,'2')}}</h3></div>
		            </div>
		        </div>
		        <div class="col-md-3">
		            <div class="card border-success mx-sm-1 p-3 green">
		                <div class="card border-success shadow text-success p-3 my-card" ><span class="fa fa-money" aria-hidden="true"></span></div>
		                <div class="text-success text-center mt-3"><h4>Paid Amount</h4></div>
		                <div class="text-success text-center mt-2"><h3>{{number_format($givenamount,'2')}}</h3></div>
		            </div>
		        </div>
		        <div class="col-md-3">
		            <div class="card border-danger mx-sm-1 p-3 red">
		                <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fa fa-money" aria-hidden="true"></span></div>
		                <div class="text-danger text-center mt-3"><h4>Due Amount</h4></div>
		                <div class="text-danger text-center mt-2"><h3>{{number_format($totalamount - $givenamount,'2')}}</h3></div>
		            </div>
		        </div>
		        <div class="col-md-3">
		            <div class="card border-warning mx-sm-1 p-3 yellow">
		                <div class="card border-warning shadow text-warning p-3 my-card" ><span class="fa fa-files-o" aria-hidden="true"></span></div>
		                <div class="text-warning text-center mt-3"><h4>Cost Invoice</h4></div>
		                <div class="text-warning text-center mt-2"><h3>{{$costinvoice->count()}}</h3></div>
		            </div>
		        </div>
		        <div class="col-md-3">
		            <div class="card border-danger mx-sm-1 p-3 red">
		                <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fa fa-upload" aria-hidden="true"></span></div>
		                <div class="text-danger text-center mt-3"><h4>Costs</h4></div>
		                <div class="text-danger text-center mt-2"><h3>{{number_format($tcosts,'2')}}</h3></div>
		            </div>
		        </div>
		        <div class="col-md-3">
		            <div class="card border-info mx-sm-1 p-3 info">
		                <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-money" aria-hidden="true"></span></div>
		                <div class="text-info text-center mt-3"><h4>Gross Profit</h4></div>
		                <div class="text-info text-center mt-2"><h3>{{$gross_profit = number_format($totalamount - $buyamount,'2')}}</h3></div>
		            </div>
		        </div>
		        <div class="col-md-3">
		            <div class="card border-success mx-sm-1 p-3 green">
		                <div class="card border-success shadow text-success p-3 my-card" ><span class="fa fa-money" aria-hidden="true"></span></div>
		                <div class="text-success text-center mt-3"><h4>Nit Profit</h4></div>
		                <div class="text-success text-center mt-2"><h3>{{number_format($nit_profit,'2')}}</h3></div>
		            </div>
		        </div>
		    </div>
	    </div>
	</div>
</div>

@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('datetime_picker/jquery.datetimepicker.js')}}"></script>
<script>
	$('#datetimepicker').datetimepicker({
      format:'Y-m-d H:i:s'
    });
</script>
@endpush