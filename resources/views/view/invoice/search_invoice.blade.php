@extends('layouts.app')
@section('title',$title)

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/mystyle.css')}}">
<!-- <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}"> -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
.search-box{
	    padding: 1px 10px !important;
}

@media (max-width: 768px){
	.search-box{
	    padding: 1px 15px !important;
}
}
</style>
@endpush


@section('content')
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow search-box">
			<!-- <div class="float-right p-0" style="margin-top: -8px;"> -->
				<form action="{{route('doctor.invoice_by_dr_date')}}" method="POST">
					<div class="row">
						@csrf
						<div class="col-md-3">
							<input type="text" name="start" id="start" style="height: 30px;" class="form-control form-control-sm" placeholder="Start Date" autocomplete="off" value="{{$start == '' ? '' : date('d-m-Y',strtotime($start))}}">
						</div>
						<div class="col-md-3">
							<input type="text" name="finish" id="finish" style="height: 30px;" class="form-control form-control-sm" placeholder="End Date" autocomplete="off" value="{{$finish == '' ? '' : date('d-m-Y',strtotime($finish))}}">
						</div>
						<div class="col-md-4">
							<select name="doctor_id" id="doctor_id" style="height: 30px;" class="form-control form-control-sm w-100" onchange="this.form.submit()">
								<option value="">Select Doctor</option>
								@foreach($doctors as $doctor)
								<option value="{{$doctor->id}}" {{$doctor->id == $doctor_id ? 'selected' : ''}}> {{$doctor->user->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2">
							<button type="submit" style="height: 100%;" class="btn btn-sm btn-block btn-info btn-padding"><i class="fa fa-search"></i> Search</button>
						</div>
					</div>
				</form>
			<!-- </div> -->
		</div>
	</div>
</div>
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
			<div class="table-responsive">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>ECOH ID</th>
							<th>Pt. Type</th>
							<th>Patient's Name</th>
							<th>Doctor's Name</th>
							<th>Amount (TK)</th>
							<th>App. Date</th>
							<th>Created at</th>
							<!-- <th>Action</th> -->
						</tr>
					</thead>
					<tbody>
						@php($total= 0)
						@foreach($invoices as $invoice)
						<tr>
							<td class="text-center">{{$loop->index +1}}</td>
							<td class="text-center">{{$invoice->centre_patient_id}}</td>
							<td class="text-center">{{$invoice->patient_type}}</td>
							<td>{{$invoice->pname}}</td>
							<td class="text-center">{{$invoice->dname}}</td>
							<td class="text-center">{{$invoice->amount}}</td>
							<td class="text-center">
								{{date('d M Y', strtotime($invoice->appoint_date))}}
							</td>
							<td class="text-center">{{date('d M Y', strtotime($invoice->created_at))}}</td>
							<!-- <td class="text-center">
								<a href="{{route('doctor.invoice.show', \Crypt::encrypt($invoice->id))}}" class=""><i class="fa fa-eye"></i> View</a>
							</td> -->
							@php($total += $invoice->amount)
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr class="text-right">
							<th colspan="5">Total</th>
							<td class="text-center">{{$total}}/=</td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
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
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
<script>
	$("#tableId").dataTable({
		pageLength : 50,
	    lengthMenu: [[50, 10, 20, 100, 500], [50, 10, 20, 100, 500]]
	});

	$(function() {
		$( "#start" ).datepicker({
			dateFormat: 'dd-mm-yy'
		});
	});

	$(function() {
		$( "#finish" ).datepicker({
			dateFormat: 'dd-mm-yy'
		});
	});
</script>
@endpush
