@extends('layouts.app')
@section('title','Cost Management')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('datetime_picker/jquery.datetimepicker.min.css')}}"/>
<style>
	.border-less{
		border-top: 0px;
	}

	select.form-control:not([size]):not([multiple]) {
	    height: 1.8rem;
	    width: 3rem;
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
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<button class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#addcost"><i class="fa fa-plus"></i> Add New</button>
			<h3 class="widget-title">Cost Name</h3>
			<div class="table-responsive">
				<table id="nametable" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#SL</th>
							<th>Cost Name</th>
							<th>Comments</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($costname as $cost)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$cost->cost_name}}</td>
							<td>{{$cost->comments}}</td>
							<td class="text-center">
								<button type="button" data-toggle="modal" data-target="#editmodal" onclick="edit({{$cost->id}})"><i class="fa fa-edit"></i></button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<button class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#createcost"><i class="fa fa-plus"></i> Create Cost</button>
			<h3 class="widget-title">Cost List</h3>
			<div class="table-responsive">
				<table id="costtable" class="table table-sm table-bordered">
					<thead>
						<tr>
							<th>#SL</th>
							<!-- <th>Description</th> -->
							<th>Cost Date</th>
							<th>Create Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($costs as $cost)
						<tr style="border-bottom: 1px solid gray !important;">
							<td>{{$loop->index +1}}</td>
							<!-- <td>{{$cost->description}}</td> -->
							<td>{{date('h:i:s a d M Y', strtotime($cost->cost_date))}}</td>
							<td>{{date('d M Y', strtotime($cost->created_at))}}</td>
							<td class="text-center">
								<button type="button" onclick="showcost({{$cost->id}})"><i class="fa fa-eye"></i></button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<style>
	.modal-content {
	    border-radius: 5px;
	}
</style>
<!-- Add Cost Name Modal -->
<div class="modal fade" id="addcost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Input Cost Name</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
	      	     <form action=" {{ route('pharmacy.cost.store') }}" method="POST" id="addcost">
					@csrf
					<input type="hidden" name="req_type" value="1">
					<div class="modal-body">
						<label for="">Cost Name</label>
						<input type="text" name="name" class="form-control form-control-sm mb-2" placeholder="Enter Cost Name">
						<label for="">Comments</label>
						<input type="text" name="comments" class="form-control form-control-sm" placeholder="Enter Comments">
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

<!-- Create Cost Modal -->
<div class="modal fade" id="createcost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Create Cost</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
	      	     <form action=" {{ route('pharmacy.cost.store') }}" method="POST">
					@csrf
					<input type="hidden" name="req_type" value="2">

					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<label for="">Description</label>
								<input type="text" name="description" class="form-control form-control-sm mb-2" placeholder="XXXXXXXX" value="XXXXXXXX">
							</div>
							<div class="col-md-6">
								<label for="">Cost Date</label>
								<input type="text" id="costdate" name="cost_date" class="form-control form-control-sm" placeholder="Enter Cost Date">
							</div>
						</div>
						
						<table class="table">
							<thead>
								<tr class="text-center">
									<th class="text-left">Cost Name</th>
									<th>Cost Price</th>
									<th class="text-right"><button type="button" class="btn btn-padding btn-sm btn-primary" style="margin-bottom: 0px;" onclick="addRow()"><i class="fa fa-plus-circle"></i> </button></th>
								</tr>
							</thead>
							<tbody id="tbody">
							</tbody>
						</table>
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
				<h5 class="modal-title">Cost Details of <span id="exampleModalLabel2"> </span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<table class="table table-sm">
					<thead>
						<tr class="text-center">
							<th class="text-left">Cost Name</th>
							<th>Cost Price</th>
						</tr>
					</thead>
					<tbody id="CostDetails">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-plus"></i> Add</button>
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
		$("#exampleModalLabel2").empty();
		$("#CostDetails").empty();
		$.ajax({
			url: '{{url('/')}}/pharmacy/cost/'+id,
			method: 'GET',
			success: function(data){
				var date = data.date.cost_date;
				var data = data.data;
				$("#exampleModalLabel2").append(date);
				$.each(data, function(key, value) {
					var details = '<tr>'+
									'<td>'+value.name+'</td>'+
									'<td class="text-center">'+value.price+'</td>'+
								'</tr>';
					$("#CostDetails").append(details);
				});
			}
		});
	};
	$('table').delegate('.remove','click', function(){
		$(this).parent().parent().remove();
	});
	$('#costdate').datetimepicker({
      format:'Y-m-d H:i:s'
    });
	$("#nametable").dataTable();
	$("#costtable").dataTable();
</script>
@endpush