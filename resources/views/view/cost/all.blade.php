@extends('layouts.app')
@section('title','Expenditure Management')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('datetime_picker/jquery.datetimepicker.min.css')}}"/>
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
			<!-- <div class="float-right p-0" style="margin-top: -8px;"> -->
				<form action="{{$auth == 'Agent' ? route('agent.expeddituresearch') : route('doctor.expeddituresearch')}}" method="POST">
					<div class="row">
						@csrf
						<div class="col-md-4">
							<input type="text" name="start" id="start" style="height: 30px;" class="form-control form-control-sm" placeholder="Start Date" @if($start) value="@if($start){{date('d-m-Y', strtotime($start))}}@endif" @endif autocomplete="off">
						</div>
						<div class="col-md-4">
							<input type="text" name="finish" id="finish" style="height: 30px;" class="form-control form-control-sm" placeholder="End Date" @if($finish) value="{{date('d-m-Y', strtotime($finish))}}" @endif autocomplete="off">
						</div>
						<div class="col-md-2">
							<select name="cost_name_id" class="form-control form-control-sm" style="height: 100%;" onchange="this.form.submit()">
								<option  value=""> Select Type </option>
								@foreach($costname as $cost)
								<option value="{{$cost->id}}" {{$cost->id == $cost_name_id ? 'selected' : ''}}> {{$cost->cost_name}} </option>
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
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endif
	</div>
<!-- 	<div class="col-md-4">
		<div class="widget-area-2 proclinic-box-shadow">
			<button class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#addcost"><i class="fa fa-plus"></i> Add New</button>
			<h3 class="widget-title">Type Name</h3>
			<div class="table-responsive">
				<table id="nametable" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#SL</th>
							<th>Type Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($costname as $cost)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$cost->cost_name}}</td>
							<td class="text-center">
								<button type="button" class="btn btn-sm btn-padding btn-primary" data-toggle="modal" data-target="#editmodal" onclick="edit({{$cost->id}})"><i class="fa fa-edit"></i></button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div> -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<button class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#createcost"><i class="fa fa-plus"></i> Add New</button>
			<h3 class="widget-title">Expenditure List</h3>
			<div class="table-responsive">
				<table id="costtable" class="table table-sm table-bordered">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Description</th>
							<th>Type</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Create Date</th>
							@if($auth == 'Doctor')
							<th>Action</th>
							@endif
						</tr>
					</thead>
					<tbody>
						@php($total = 0)
						@foreach($costs as $cost)
						<tr style="border-bottom: 1px solid gray !important;">
							<td>{{$loop->index +1}}</td>
							<td>{{$cost->description}}</td>
							<td>{{$cost->cost_name}}</td>
							<td class="text-right">{{$cost->amount}}</td>
							<td class="text-center">{{date('d M Y', strtotime($cost->date))}}</td>
							<td class="text-center">{{date('d M Y', strtotime($cost->created_at))}}</td>
							@if($auth == 'Doctor')
							<td class="text-center">
								<button type="button" class="btn btn-sm btn-padding btn-info" onclick="showcost({{$cost->id}})"><i class="fa fa-edit"></i></button>
							</td>
							@endif
							@php($total += $cost->amount)
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3" class="text-right">Total</th>
							<th class="text-right">{{$total}}</th>
							<th class="text-center"></th>
							<th class="text-center"></th>
							@if($auth == 'Doctor')
							<th class="text-center"></th>
							@endif
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

<style>

</style>
<!-- Add Cost Name Modal -->
<div class="modal fade" id="addcost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Input Expenditure Type</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
	      	     <form action=" {{$auth == 'Doctor' ? route('doctor.cost.store') : route('agent.cost.store') }}" method="POST" id="addcost">
					@csrf
					<input type="hidden" name="req_type" value="1">
					<div class="modal-body">
						<label for="">Type Name</label>
						<input type="text" name="name" class="form-control form-control-sm mb-2" placeholder="Enter Type Name">
						<!-- <label for="">Comments</label>
						<input type="text" name="comments" class="form-control form-control-sm" placeholder="Enter Comments">
						<div for="">Status</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" checked type="radio" name="status" id="inlineRadio1" value="1">
						  <label class="form-check-label" for="inlineRadio1">Active</label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
						  <label class="form-check-label" for="inlineRadio2">Deactive</label>
						</div> -->
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-plus"></i> Add</button>
					</div>
				</form>
	    </div>
  	</div>
</div>

<!-- Edit Cost Name Modal -->
<div class="modal fade" id="editcostname" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Type Name</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="edit">

			</div>
	    </div>
  	</div>
</div>

<!-- Create Cost Modal -->
<div class="modal fade" id="createcost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Create Expenditure</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
	      	     <form action=" {{$auth == 'Doctor' ? route('doctor.cost.store') : route('agent.cost.store') }}" method="POST">
					@csrf
					<input type="hidden" name="req_type" value="2">
					<div class="modal-body">
						<div class="row">
							<label for="">Expenditure Type</label>
							<select type="text" name="cost_name_id" class="form-control form-control-sm mb-2">
								<option selected="false" disabled>Select Expenditure Type</option>
								@foreach($costname as $cost)
								<option value="{{$cost->id}}">{{$cost->cost_name}}</option>
								@endforeach
							</select>
							<label for="">Description</label>
							<input type="text" name="description" class="form-control form-control-sm mb-2" placeholder="Enter Description">
							<label for="">Amount</label>
							<input type="text" name="amount" class="form-control form-control-sm mb-2" placeholder="Enter Amount">
							<label for="">Date</label>
							<input type="text" id="costdate" name="cost_date" class="form-control form-control-sm" placeholder="Enter Date" readonly autocomplete="off">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-plus"></i> Add</button>
					</div>
				</form>
	    </div>
  	</div>
</div>

<!-- Show Cost Details Modal -->
<div class="modal fade" id="showcost">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"> Edit <span id="exampleModalLabel2"> </span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div id="CostDetails">
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
	function edit(id){
		$("#edit").empty();
		if ("{{$auth == 'Agent'}}") {
			var url = "{{url('/')}}/agent/cost/"+id+"/edit";
		}else{
			var url = "{{url('/')}}/doctor/cost/"+id+"/edit";
		}
		console.log(url);
		$.ajax({
			url: url,
			method: "GET",
			success: function(data){
				console.log(data);
				$("#editcostname").modal('show');
				var editrow = '<form action="{{url('/')}}/doctor/cost/'+data.id+'" method="POST">'+
							'@csrf'+
							'@method("PUT")'+
							'<input type="hidden" name="req_type" value="1">'+
							'<div class="modal-body">'+
								'<label for="">Type Name</label>'+
								'<input type="text" name="name" class="form-control form-control-sm mb-2" value="'+data.cost_name+'" placeholder="Enter Type Name">'+
								// '<label for="">Comments</label>'+
								// '<input type="text" name="comments" class="form-control form-control-sm" value="'+(data.comments == "null" ? " ":data.comments)+'" placeholder="Enter Comments">'+
								// '<div for="">Status</div>'+
								// '<div class="form-check form-check-inline">'+
								//   '<input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1"'+(data.status == 1 ? "checked":"")+'>'+
								//   '<label class="form-check-label" for="inlineRadio1">Active</label>'+
								// '</div>'+
								// '<div class="form-check form-check-inline">'+
								//   '<input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0"'+(data.status == 0 ? "checked":"")+'>'+
								//   '<label class="form-check-label" for="inlineRadio2">Deactive</label>'+
								// '</div>'+
							'</div>'+
							'<div class="modal-footer">'+
								'<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-refresh"></i> Update</button>'+
							'</div>'+
						'</form>';
				$('#edit').html(editrow);
			}
		});
		
	};
	function addRow(){
		var newrow = '<tr>'+
						'<td style="border-top: 0px;">'+
						'<select name="cost_name_id[]" class="form-control-sm w-100 medicine">'+
							'<option selected="false" disabled> Select Medicine </option>'+
							'@foreach($costname as $cost)'+
							'<option value="{{$cost->id}}"> {{$cost->cost_name}} </option>'+
							'@endforeach'+
						'</select>'+
						'</td>'+
						'<td style="border-top: 0px;"><input type="text" name="cost_price[]" class="form-control-sm w-100 price text-right"></td>'+
						'<td class="text-right" style="border-top: 0px;"><button type="button" class="btn btn-padding btn-sm btn-danger remove" style="margin-bottom: 0px;"><i class="fa fa-times"></i> </button></td>'+
					'</tr>';
		$('#tbody').prepend(newrow);
	};

	function showcost(id){
		$("#showcost").modal('show');
		$("#CostDetails").empty();

		if ("{{$auth == 'Agent'}}") {
			var url = "{{url('/')}}/agent/cost/"+id;
		}else{
			var url = "{{url('/')}}/doctor/cost/"+id;
		}
		console.log(url);
		$.ajax({
			url: url,
			method: 'GET',
			success: function(data){
					var editexpend = '<form action="'+url+'" method="POST">'+
						'@csrf'+
						'@method("PUT")'+
						'<input type="hidden" name="req_type" value="2">'+
						'<div class="modal-body">'+
							'<div class="row">'+
								'<label for="">Expenditure Type</label>'+
								'<select type="text" name="cost_name_id" class="form-control form-control-sm mb-2">'+
									'<option selected="false" disabled>Select Expenditure Type</option>'+
									'@foreach($costname as $cost)'+
									'<option value="{{$cost->id}}"'+ (data.cost_name_id == "{{$cost->id}}" ? "selected" : "" )+'>{{$cost->cost_name}}</option>'+
									'@endforeach'+
								'</select>'+
								'<label for="">Description</label>'+
								'<input type="text" name="description" class="form-control form-control-sm mb-2" placeholder="Enter Description" value="'+ data.description+'">'+
								'<label for="">Amount</label>'+
								'<input type="text" name="amount" class="form-control form-control-sm mb-2" placeholder="Enter Amount" value="'+ data.amount+'">'+
								'<label for="">Date</label>'+
								'<input type="text" id="editcostdate" name="cost_date" class="form-control form-control-sm" placeholder="Enter Date" readonly autocomplete="off"  value="'+ data.date+'">'+
							'</div>'+
						'</div>'+
						'<div class="modal-footer">'+
							'<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-refresh"></i> Update</button>'+
						'</div>'+
					'</form>';
					$(function(){
						$('#editcostdate').datetimepicker({
					      format:'Y-m-d',
					      timepicker:false
					    });
					});
				$("#CostDetails").append(editexpend);
			}
		});
	};
	$('table').delegate('.remove','click', function(){
		$(this).parent().parent().remove();
	});
	$('#costdate').datetimepicker({
      format:'d-m-Y',
      timepicker:false
    });
	$('#start').datetimepicker({
      format:'d-m-Y',
      timepicker:false
    });
	$('#finish').datetimepicker({
      format:'d-m-Y',
      timepicker:false
    });
	
	$("#nametable").dataTable({
		// pageLength : 3,
	});
	$("#costtable").dataTable();
</script>
@endpush