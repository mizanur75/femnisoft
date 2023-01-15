@extends('layouts.app')
@section('title','All Doctor')

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
			<div class="table-responsive mb-3">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#SL</th>
							<th>ID</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Role</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($doctors as $doctor)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$doctor->id}}</td>
							<td>{{$doctor->name}}</td>
							<td>{{$doctor->phone}}</td>
							<td>{{$doctor->email}}</td>
							<td>{{$doctor->role->name}}</td>
							<td class="text-center">
								@if($doctor->status == 0)
								<span class="badge badge-danger">Not Active</span>
								@else
								<span class="badge badge-success">Active</span>
								@endif
							</td>
							<td class="text-center">
								<button class="btn btn-padding btn-sm btn-info" type="button" onclick="doctor_details({{$doctor->id}})" data-toggle="modal" data-target="#doctor"><i class="fa fa-eye"></i></button>
								<a href="{{route('admin.user.edit',$doctor->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>
								<form action="{{route('admin.user.destroy', $doctor->id)}}" method="post"
									style="display: inline;"
									onsubmit="return confirm('Are you Sure? Want to delete')">
									@csrf
									@method('DELETE')
									<button class="btn btn-padding btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i>
									</button>
								</form>
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
<div class="modal fade" id="doctor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" id="doctordetails">
	</div>
</div>
@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script>
	function doctor_details(id){
		$("#doctordetails").empty();
		var male = 'Male';
		var female = 'Female';
		$.ajax({
			url: "{{url('/')}}/admin/doctor-details/"+id,
			method: "GET",
			success: function(data){
				console.log(data);
				$("#doctordetails").append(
				'<div class="modal-content">'+
					'<div class="modal-header">'+
					'<h5 class="modal-title" id="exampleModalLabel">Details of '+data.name+' </h5>'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
					  '<span aria-hidden="true">&times;</span>'+
					'</button>'+
					'</div>'+
					'<div class="modal-body">'+
						'<div class="row">'+
							'<div class="col-sm-3 text-center">'+
								'<div class="form-group">'+
									'<img style="width: 100%;" src="{{url('/')}}/images/doctor/'+data.image+' "/>'+
								'</div><hr>'+
								'<h3>'+data.title+'</h3><hr>'+
								'<button class="btn btn-padding btn-sm btn-block '+(data.status == 1 ? "btn btn-padding-success":"btn btn-padding-danger")+'">'+(data.status == 1 ? "Available":"Busy")+'</button>'+
							'</div>'+
							'<div class="col-md-9">'+
			                    '<div class="table-responsive">'+
			                        '<table class="table table-bordered table-striped">'+
			                            '<tbody>'+
			                                '<tr>'+
			                                    '<td><strong>Specialization</strong></td>'+
			                                    '<td>'+data.specialist+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Current Work</strong></td>'+
			                                    '<td>'+data.current_work_station+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Experience</strong></td>'+
			                                    '<td>'+data.experience+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Education</strong></td>'+
			                                    '<td>'+data.education+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Gender</strong></td>'+
			                                    '<td>'+(data.gender == 0 ? male : female )+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Phone</strong> </td>'+
			                                    '<td>'+data.phone+'</td>'+
			                                '</tr>'+
			                                '<tr>'+
			                                    '<td><strong>Email</strong></td>'+
			                                    '<td>'+data.email+'</td>'+
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