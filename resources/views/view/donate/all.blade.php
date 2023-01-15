@extends('layouts.app')
@section('title','Donation Management')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('datetime_picker/jquery.datetimepicker.min.css')}}"/>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<style>
		.border-less{
			border-top: 0px;
		}
	</style>
@endpush

@section('content')
@php($auth = Auth::user()->role->name)
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow search-box">
			<form action="{{$auth == 'Agent' ? route('agent.donation_search') : route('doctor.donation_search')}}" method="POST">
				<div class="row">
					@csrf
					<div class="col-md-4">
						<input type="text" name="start" id="start" style="height: 30px;" class="form-control form-control-sm" placeholder="Start Date" @if($start) value="@if($start){{date('d-m-Y', strtotime($start))}}@endif" @endif autocomplete="off">
					</div>
					<div class="col-md-4">
						<input type="text" name="finish" id="finish" style="height: 30px;" class="form-control form-control-sm" placeholder="End Date" @if($finish) value="{{date('d-m-Y', strtotime($finish))}}" @endif autocomplete="off">
					</div>
					<div class="col-md-2">
						<select name="payment_from" class="form-control form-control-sm" style="height: 100%;" onchange="this.form.submit()">
							<option  value=""> Select </option>
							<option value="1"> Donor </option>
							<option value="2"> Member </option>
							<option value="3"> Miscellaneous </option>
						</select>
					</div>
					<div class="col-md-2">
						<button type="submit" style="height: 100%;" class="btn btn-sm btn-block btn-info btn-padding"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
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
	@php($store = $auth == 'Doctor' ? route('doctor.donate.store') : route('agent.donate.store'))
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			@if($errors->any())
			@foreach($errors->all() as $error)
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<strong>Opps!</strong> {{$error}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			@endforeach
			@endif
			<button class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#adddonate"><i class="fa fa-plus"></i> Add New</button>
			<h3 class="widget-title">Donation/Member(s) Fee</h3>
			<div class="table-responsive">
				<table id="nametable" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Invoice No.</th>
							<th>Payment By</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Payment Type</th>
							<th>Amount (Tk)</th>
							<th>Donation Date</th>
							<th>Create Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@php($total=0)
						@foreach($donates as $donar)
							<tr>
								<td>{{$loop->index +1}}</td>
								<td class="text-center">ECOH-{{$donar->id}}</td>
								<td>
									@if($donar->payment_from == 1)
								 		Donor
								 	@elseif($donar->payment_from == 2)
								 		Member
								 	@else
								 		Miscellaneous
								 	@endif
								</td>
								<td>{{$donar->name}}</td>
								<td>{{$donar->address}}</td>
								<td>{{$donar->phone}}</td>
								<td class="text-center">
									{{$donar->pay_by}}
								</td>
								<td class="text-center">{{$donar->amount}}</td>
								<td class="text-center">{{date('d M Y', strtotime($donar->donate_date))}}</td>
								<td class="text-center">{{date('d M Y', strtotime($donar->created_at))}}</td>
								<td class="text-center">
									@if($auth == 'Doctor' || $auth == 'Central')
									<button type="button" class="btn btn-sm btn-padding btn-primary" data-toggle="modal" data-target="#editmodal" onclick="edit({{$donar->id}})"><i class="fa fa-edit"></i></button>
									@endif
									<!-- <button type="button" class="btn btn-sm btn-padding btn-primary" onclick="Swal.fire('You are not Authorized')"><i class="fa fa-edit"></i></button>
 -->									<a href="{{$auth == 'Doctor' ? route('doctor.donate.show',$donar->id) : route('agent.donate.show',$donar->id)}}" target="_blank" class="btn btn-sm btn-padding btn-primary"> <i class="fa fa-file-invoice"></i></a>
									
								</td>
							</tr>
							@php($total += $donar->amount)
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="7" class="text-right">Total (Tk)</th>
							<th class="text-center">{{$total}}/=</th>
							<th class="text-center"></th>
							<th class="text-center"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

<style>

</style>
<!-- Add donate Name Modal -->
<div class="modal fade" id="adddonate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Input Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
	      	     <form action=" {{ $store }}" method="POST" id="adddonate">
					@csrf
					<input type="hidden" name="req_type" value="1">
					<div class="modal-body">
						<label for="">Payment By</label>
						<select name="payment_from" class="form-control form-control-sm">
							<option selected="false" disabled> Select </option>
							<option value="1"> Donor </option>
							<option value="2"> Member </option>
							<option value="3"> Miscellaneous </option>
						</select>
						<label for="">Date</label>
						<input type="text" name="date" id="donate_date" class="form-control form-control-sm mb-2" placeholder="Enter Date" autocomplete="off">
						<label for="">Name</label>
						<input type="text" name="name" class="form-control form-control-sm mb-2" placeholder="Enter Name">
						<label for="">Address</label>
						<input type="text" name="address" class="form-control form-control-sm" placeholder="Enter Address">
						<label for="">Phone</label>
						<input type="text" name="phone" class="form-control form-control-sm" placeholder="Enter Phone">
						<label for="">Amount (Tk)</label>
						<input type="number" name="amount" class="form-control form-control-sm" placeholder="Enter Amount in TK">
						<label for="">Payment Type</label>
						<select name="pay_by" class="form-control form-control-sm">
							<option selected="false" disabled> Select </option>
							<option value="Cash"> Cash </option>
							<option value="Bank Transfer"> Bank Transfer </option>
							<option value="Mobile Banking"> Mobile Banking </option>
						</select>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
					</div>
				</form>
	    </div>
  	</div>
</div>

<!-- Edit donate Name Modal -->
<div class="modal fade" id="editdonatename" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="edit">

			</div>
	    </div>
  	</div>
</div>

@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('datetime_picker/jquery.datetimepicker.js')}}"></script>
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
<script>
	function edit(id){
		$("#edit").empty();
		if ("{{$auth == 'Doctor'}}") {
			editeurl = "{{url('/')}}/doctor/donate/"+id+"/edit";
		}else{
			editeurl = "{{url('/')}}/agent/donate/"+id+"/edit";
		}
		$.ajax({
			url: editeurl,
			method: "GET",
			success: function(data){
				if ("{{$auth == 'Doctor'}}") {
					updateurl = "{{url('/')}}/doctor/donate/"+data.id;
				}else{
					updateurl = "{{url('/')}}/agent/donate/"+data.id;
				}
				$("#editdonatename").modal('show');
				var editrow = '<form action="'+updateurl+'" method="POST">'+
							'@csrf'+
							'@method("PUT")'+
							'<div class="modal-body">'+
								'<label for="">Payment By</label>'+
								'<select name="payment_from" class="form-control form-control-sm">'+
									'<option selected="false" disabled> Select </option>'+
									'<option value="1" '+ (data.payment_from == "1" ? "selected" : "" )+'> Donor </option>'+
									'<option value="2" '+ (data.payment_from == "2" ? "selected" : "" )+'> Member </option>'+
									'<option value="3" '+ (data.payment_from == "3" ? "selected" : "" )+'> Miscellaneous </option>'+
								'</select>'+
								'<label for="">Date</label>'+
								'<input type="text" name="date" class="donate_date form-control form-control-sm mb-2" value="'+data.donate_date+'" placeholder="Enter donar Name">'+'<label for="">Donor Name</label>'+
								'<input type="text" name="name" class="form-control form-control-sm mb-2" value="'+data.name+'" placeholder="Enter donar Name">'+
								'<label for="">Address</label>'+
								'<input type="text" name="address" class="form-control form-control-sm" value="'+data.address+'" placeholder="Enter address">'+
								'<label for="">Phone</label>'+
								'<input type="text" name="phone" class="form-control form-control-sm" value="'+data.phone+'" placeholder="Enter Phone">'+
								'<label for="">Amount</label>'+
								'<input type="text" name="amount" class="form-control form-control-sm" value="'+data.amount+'" placeholder="Enter amount">'+
								'<label for="">Payment Type</label>'+
								'<select name="pay_by" class="form-control form-control-sm">'+
									'<option selected="false" disabled> Select </option>'+
									'<option value="Cash" '+ (data.pay_by == "Cash" ? "selected" : "" )+'> Cash </option>'+
									'<option value="Bank-Transfer" '+ (data.pay_by == "Bank Transfer" ? "selected" : "" )+'> Bank Transfer </option>'+
									'<option value="Mobile Banking" '+ (data.pay_by == "Mobile Banking" ? "selected" : "" )+'> Mobile Banking </option>'+
								'</select>'+
							'</div>'+
							'<div class="modal-footer">'+
								'<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-refresh"></i> Update</button>'+
							'</div>'+
						'</form>';
						$(function() {
							$( ".donate_date" ).datepicker({
								dateFormat: 'dd-mm-yy'
							})
						})
				$('#edit').html(editrow);
			}
		});
		
	};

	function showdonate(id){
		$("#showdonate").modal('show');
		$("#exampleModalLabel2").empty();
		$("#donateDetails").empty();
		$.ajax({
			url: '{{url('/')}}/pharmacy/donate/'+id,
			method: 'GET',
			success: function(data){
				var date = data.date.donate_date;
				var data = data.data;
				$("#exampleModalLabel2").append(date);
				$.each(data, function(key, value) {
					var details = '<tr>'+
									'<td>'+value.name+'</td>'+
									'<td class="text-center">'+value.price+'</td>'+
								'</tr>';
					$("#donateDetails").append(details);
				});
			}
		});
	};
	$('table').delegate('.remove','click', function(){
		$(this).parent().parent().remove();
	});
	$('#donatedate').datetimepicker({
      format:'Y-m-d H:i:s'
    });
	$("#nametable").dataTable();
	$("#donatetable").dataTable();

	$(function() {
		$( "#start" ).datepicker({
			dateFormat: 'dd-mm-yy',
			maxDate: 0
		});
	});

	$(function() {
		$( "#finish" ).datepicker({
			dateFormat: 'dd-mm-yy',
			maxDate: 0
		});
	});
	$(function() {
		$( "#donate_date" ).datepicker({
			dateFormat: 'dd-mm-yy',
			maxDate: 0
		});
	});
	$(function() {
		$( ".donate_date" ).datepicker({
			dateFormat: 'dd-mm-yy',
			maxDate: 0
		});
	});
</script>
@endpush