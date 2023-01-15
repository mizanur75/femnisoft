@extends('layouts.app')
@section('title','Balance Forward')

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
			<form action="{{$auth == 'Agent' ? route('agent.miscellaneouses_search') : route('doctor.miscellaneouses_search')}}" method="POST">
				<div class="row">
					@csrf
					<div class="col-md-4">
						<input type="text" name="start" id="start" style="height: 30px;" class="form-control form-control-sm" placeholder="Start Date" @if($start) value="@if($start){{date('d-m-Y', strtotime($start))}}@endif" @endif autocomplete="off">
					</div>
					<div class="col-md-4">
						<input type="text" name="finish" id="finish" style="height: 30px;" class="form-control form-control-sm" placeholder="End Date" @if($finish) value="{{date('d-m-Y', strtotime($finish))}}" @endif autocomplete="off">
					</div>
					<!-- <div class="col-md-2">
						<select name="payment_from" class="form-control form-control-sm" style="height: 100%;" onchange="this.form.submit()">
							<option  value=""> Select </option>
							<option value="1"> Donor </option>
							<option value="2"> Miscellaneous </option>
						</select>
					</div> -->
					<div class="col-md-4">
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
	@php($store = $auth == 'Doctor' ? route('doctor.miscellaneous.store') : route('agent.miscellaneous.store'))
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
			<h3 class="widget-title">Balance Forward</h3>
			<div class="table-responsive">
				<table id="nametable" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Invoice No.</th>
							<!-- <th>Payment By</th> -->
							<th>Description</th>
							<!-- <th>Address</th> -->
							<!-- <th>Phone</th> -->
							<!-- <th>Payment Type</th> -->
							<th>Amount (Tk)</th>
							<th>Date</th>
							<th>Create Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@php($total=0)
						@foreach($miscellaneouses as $miscellaneous)
							<tr>
								<td>{{$loop->index +1}}</td>
								<td class="text-center">ECOH-{{$miscellaneous->id}}</td>
								<!-- <td>{{$miscellaneous->payment_from == 1 ? 'Donor' : 'Miscellaneous'}}</td> -->
								<td>{{$miscellaneous->name}}</td>
								<!-- <td>{{$miscellaneous->address}}</td>
								<td>{{$miscellaneous->phone}}</td>
								<td class="text-center">{{$miscellaneous->pay_by == '1' ? 'Cash' : 'Bank-Transfer'}}</td> -->
								<td class="text-center">{{$miscellaneous->amount}}</td>
								<td class="text-center">{{date('d M Y', strtotime($miscellaneous->date))}}</td>
								<td class="text-center">{{date('d M Y', strtotime($miscellaneous->created_at))}}</td>
								<td class="text-center">
									@if($auth == 'Doctor' || $auth == 'Central')
									<button type="button" class="btn btn-sm btn-padding btn-primary" data-toggle="modal" data-target="#editmodal" onclick="edit({{$miscellaneous->id}})"><i class="fa fa-edit"></i></button>
									@endif
									<!-- <button type="button" class="btn btn-sm btn-padding btn-primary" onclick="Swal.fire('You are not Authorized')"><i class="fa fa-edit"></i></button>
 -->									<a href="{{$auth == 'Doctor' ? route('doctor.miscellaneous.show',$miscellaneous->id) : route('agent.miscellaneous.show',$miscellaneous->id)}}" target="_blank" class="btn btn-sm btn-padding btn-primary"> <i class="fa fa-file-invoice"></i></a>
									
								</td>
							</tr>
							@php($total += $miscellaneous->amount)
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3" class="text-right">Total (Tk)</th>
							<th class="text-center">{{$total}}/=</th>
							<th class="text-center"></th>
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
						<!-- <label for="">Payment By</label>
						<select name="payment_from" class="form-control form-control-sm">
							<option selected="false" disabled> Select </option>
							<option value="1"> Donor </option>
							<option value="2"> Member </option>
						</select> -->
						<label for="">Date</label>
						<input type="text" name="date" id="donate_date" class="form-control form-control-sm mb-2" placeholder="Enter Date" autocomplete="off">
						<label for="">Description</label>
						<input type="text" name="name" class="form-control form-control-sm mb-2" placeholder="Enter Description">
						<!-- <label for="">Address</label>
						<input type="text" name="address" class="form-control form-control-sm" placeholder="Enter Address">
						<label for="">Phone</label>
						<input type="text" name="phone" class="form-control form-control-sm" placeholder="Enter Phone"> -->
						<label for="">Amount (Tk)</label>
						<input type="number" name="amount" class="form-control form-control-sm" placeholder="Enter Amount in TK">
						<!-- <label for="">Payment Type</label>
						<select name="pay_by" class="form-control form-control-sm">
							<option selected="false" disabled> Select </option>
							<option value="1"> Cash </option>
							<option value="2"> Bank-Transfer </option>
						</select> -->
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
					</div>
				</form>
	    </div>
  	</div>
</div>

<!-- Edit donate Name Modal -->
<div class="modal fade" id="editmiscellaneous" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
			editeurl = "{{url('/')}}/doctor/miscellaneous/"+id+"/edit";
		}else{
			editeurl = "{{url('/')}}/agent/miscellaneous/"+id+"/edit";
		}
		$.ajax({
			url: editeurl,
			method: "GET",
			success: function(data){
				if ("{{$auth == 'Doctor'}}") {
					updateurl = "{{url('/')}}/doctor/miscellaneous/"+data.id;
				}else{
					updateurl = "{{url('/')}}/agent/miscellaneous/"+data.id;
				}
				$("#editmiscellaneous").modal('show');
				var editrow = '<form action="'+updateurl+'" method="POST">'+
							'@csrf'+
							'@method("PUT")'+
							'<div class="modal-body">'+
								// '<label for="">Payment Type</label>'+
								// '<select name="payment_from" class="form-control form-control-sm">'+
								// 	'<option selected="false" disabled> Select </option>'+
								// 	'<option value="1" '+ (data.payment_from == "1" ? "selected" : "" )+'> Donor </option>'+
								// 	'<option value="2" '+ (data.payment_from == "2" ? "selected" : "" )+'> Member </option>'+
								// '</select>'+
								'<label for="">Date</label>'+
								'<input type="text" name="date" class="miscellaneous_date form-control form-control-sm mb-2" value="'+data.date+'" placeholder="Enter Date">'+
								'<label for="">Description</label>'+
								'<input type="text" name="name" class="form-control form-control-sm mb-2" value="'+data.name+'" placeholder="Enter Description">'+
								// '<label for="">Address</label>'+
								// '<input type="text" name="address" class="form-control form-control-sm" value="'+data.address+'" placeholder="Enter address">'+
								// '<label for="">Phone</label>'+
								// '<input type="text" name="phone" class="form-control form-control-sm" value="'+data.phone+'" placeholder="Enter Phone">'+
								// '<label for="">Amount</label>'+
								'<input type="text" name="amount" class="form-control form-control-sm" value="'+data.amount+'" placeholder="Enter amount">'+
								// '<label for="">Payment Type</label>'+
								// '<select name="pay_by" class="form-control form-control-sm">'+
								// 	'<option selected="false" disabled> Select </option>'+
								// 	'<option value="1" '+ (data.pay_by == "1" ? "selected" : "" )+'> Cash </option>'+
								// 	'<option value="2" '+ (data.pay_by == "2" ? "selected" : "" )+'> Bank-Transfer </option>'+
								// '</select>'+
							'</div>'+
							'<div class="modal-footer">'+
								'<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-refresh"></i> Update</button>'+
							'</div>'+
						'</form>';
						$(function() {
							$( ".miscellaneous_date" ).datepicker({
								dateFormat: 'dd-mm-yy'
							})
						})
				$('#edit').html(editrow);
			}
		});
		
	};

	function showmiscellaneous(id){
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