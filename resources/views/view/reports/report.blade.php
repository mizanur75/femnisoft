@extends('layouts.app')
@section('title',$title.' Report')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('fontawesome/css/fontawesome.css')}}"/>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
	    	<form action="{{ Auth::user()->role->name == 'Doctor' ? route('doctor.diffDate') : route('agent.diffDate') }}" method="GET">
    			<div class="row" style="padding: 10px;">
		        	<div class="col-md-4">
		    			<div class="card border-primary mx-sm-1 p-3 blue">
		    				<input type="text" class="form-control form-control-sm" name="start" id="start" placeholder="Enter Start Date" value="{{$start == null ? '' : date('d-m-Y', strtotime($start))}}" autocomplete="off">
			            </div>
			        </div>
			        <div class="col-md-4">
			            <div class="card border-primary mx-sm-1 p-3 blue">
		    				<input type="text" class="form-control form-control-sm" name="finish" id="finish" value="{{$finish == null ? '' : date('d-m-Y', strtotime($finish))}}" placeholder="Enter Finished Date" autocomplete="off">
			            </div>
			        </div>
			        <div class="col-md-4">
			            <div class="card border-primary mx-sm-1 p-3 blue">
		    				<button type="submit" class="form-control">Generate Report</button>
			            </div>
			        </div>
    			</div>
    		</form>
    	</div>
    </div>
	<div class="col-md-12" id="printarea">
	    <div class="widget-area-2 proclinic-box-shadow color-red">
			<div class="row pl-4 pr-4 mb-4">
				<div class="table-responsive color-black">
					<div>
						<span class="h3 mr-4">Financial Statement
							<br>
							<span class="h5">Ekhlaspur Center of Health</span>
						</span>
						<span>@if($start == !null) From: {{$start == null ? '' : date('d M Y', strtotime($start))}} To: {{$finish == null ? '' : date('d M Y', strtotime($finish))}}@endif</span><span class="btn btn-padding btn-sm btn-success float-right" id="print"><i class="fa fa-print"></i> Print</span><br>

					</div>
					<hr>
					<h4>Income</h4>
					<table class="table table-sm table-bordered table-striped">
						<thead>
							<tr class="text-center">
								<th width="10%">#SL</th>
								<th width="50%">Name</th>
								<th width="40%">Amount (Tk)</th>
							</tr>
						</thead>
						<tbody>
							<tr class="text-center">
								<td>1</td>
								<td>Balance Forward</td>
								<td>{{number_format($miscellaneous_amount, 0, '', ',')}}</td>
							</tr>
							<tr class="text-center">
								<td>2</td>
								<td>Consultation</td>
								<td>{{number_format($consult_amount, 0, '', ',')}}</td>
							</tr>
							<tr class="text-center">
								<td>3</td>
								<td>Labratory</td>
								<td>{{number_format($lab_amount, 0, '', ',')}}</td>
							</tr>
							<tr class="text-center">
								<td>4</td>
								<td>Donation</td>
								<td>{{number_format($donate_amount, 0, '', ',')}}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="2" class="text-right">Total (Tk)</th>
								<th class="text-center">{{number_format(($consult_amount + $lab_amount + $donate_amount + $miscellaneous_amount), 0,'',',')}}/=</th>
							</tr>
						</tfoot>
					</table>
					<h4>Expenditure</h4>
					<table class="table table-sm table-bordered table-striped">
						<thead>
							<tr class="text-center">
								<th width="10%">#SL</th>
								<th width="50%">Name</th>
								<th width="40%">Amount (Tk)</th>
							</tr>
						</thead>
						<tbody>
							<tr class="text-center">
								<td>1</td>
								<td>Salary</td>
								<td>{{number_format($salary_amount, 0, '', ',')}}</td>
							</tr>
							<tr class="text-center">
								<td>2</td>
								<td>Diagnostics</td>
								<td>{{number_format($diagnostics_amount, 0, '', ',')}}</td>
							</tr>
							<tr class="text-center">
								<td>3</td>
								<td>Others</td>
								<td>{{number_format($others_amount, 0, '', ',')}}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="2" class="text-right">Total (Tk)</th>
								<th class="text-center">{{number_format(($salary_amount + $diagnostics_amount + $others_amount), 0,'',',')}}/=</th>
							</tr>
							<tr class="background-color">
								<th colspan="2" class="text-right">Balance (Tk)</th>
								<th class="text-center">
									@php($balance = ($consult_amount + $lab_amount + $donate_amount + $miscellaneous_amount) - ($salary_amount + $diagnostics_amount + $others_amount))
								{{number_format($balance, 0,'',',')}}/=</th>
							</tr>
						</tfoot>
					</table>
					<span>Developed by Primex Information System Ltd.</span>
				</div>
		    </div>
	    </div>
	</div>
</div>

@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<!-- <script src="{{asset('datetime_picker/jquery.datetimepicker.js')}}"></script> -->
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
<script>
    $("#print").click(function () {
    	$("#print").addClass('d-none');
        $("#printarea").show();
        window.print();
        $("#print").removeClass('d-none');
        window.onafterprint = function () {
		    $("#print").removeClass('d-none');
		}
    });
</script>
<script>
    $(function() {
			$( "#start" ).datepicker({
				dateFormat: 'dd-mm-yy',
				changeYear: true,
				changeMonth: true
			});
		});

		$(function() {
			$( "#finish" ).datepicker({
				dateFormat: 'dd-mm-yy',
				changeYear: true,
				changeMonth: true
			});
		});
</script>
@endpush