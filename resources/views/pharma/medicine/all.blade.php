@extends('layouts.app')
@section('title','All Medicine/Trade Name')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
}
</style>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right">
			<!-- Button trigger modal -->
			<a href="{{route('pharma.medicine.create')}}" class="btn btn-padding btn-sm btn-primary">
			  <i class="fa fa-plus"></i> Add New
			</a>
        </div>
    </div>
    @if($errors->any())
	    @foreach($errors->all() as $error)
	    <div class="col-md-12">
	    	<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>{{ $error }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		</div>
	    @endforeach
    @endif
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
						<tr class="text-center">
							<th>#SL</th>
							<th>Generic Name</th>
							<th>Medicine/Trade Name</th>
							<th>Disease</th>
							<th>Side Effect</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($medicines as $medicine)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$medicine->generic}}</td>
							<td>{{$medicine->name}}</td>
							<td>{{$medicine->disease}}</td>
							<td>{{$medicine->side_effect}}</td>
							<td class="text-center">
								<button type="button" class="btn btn-padding btn-sm btn-primary"  onclick="med_details({{$medicine->id}})" data-toggle="modal" data-target="#medicine"><i class="fa fa-eye"></i></button>
								@if($medicine->user_id == Auth::user()->id)
								<a href="{{route('pharma.medicine.edit',$medicine->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>
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


<!-- Modal -->
<div class="modal fade" id="medicine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" id="medicinedetails">
		
	</div>
</div>
@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script>
	function med_details(id){
		$("#medicinedetails").empty();
		var active = '<span class="color-green">Active</span>';
		var deactive = '<span class="color-red">Deactive</span>';
		$.ajax({
			url: "{{url('/')}}/pharma/medicine/"+id,
			method: "GET",
			success: function(data){
				console.log(data);
				var medicine = data.medicine;
				$("#medicinedetails").append(
				'<div class="modal-content">'+
					'<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Details of '+medicine.name+' </h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
					'</div>'+
					'<div class="modal-body">'+
						'<div class="row">'+
							'<div class="col-md-12">'+
			                    '<div class="table-responsive">'+
			                        '<table class="table table-bordered table-striped">'+
			                            '<tbody>'+
			                                '<tr>'+
			                                    '<td><strong>Pharmaceuticals Name</strong></td>'+
			                                    '<td>'+medicine.pharmaname+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Generic Name</strong></td>'+
			                                    '<td>'+medicine.generic+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Description</strong></td>'+
			                                    '<td>'+medicine.description+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Disease Indication</strong> </td>'+
			                                    '<td>'+medicine.disease+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Doses</strong></td>'+
			                                    '<td>'+medicine.doses+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Side Efect</strong></td>'+
			                                    '<td>'+medicine.side_effect+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Status</strong></td>'+
			                                    '<td>'+(medicine.status == 1 ? active : deactive )+'</td>'+
			                                '</tr>'+
			                            '</tbody>'+
			                        '</table>'+
			                    '</div>'+
			                '</div>'+
						'</div>'+

					'</div>'+
					'<div class="modal-footer">'+
						'<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal">Close</button>'+
					'</div>'+
			    '</div>'
				);
			}
		});
	}
	$("#tableId").dataTable();
</script>
@endpush