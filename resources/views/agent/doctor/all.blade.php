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
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Available</th>
							<th>Profile. Dt.</th>
							@if(Auth::user()->role->name == "Agent")
							<th>Appointment</th>
							@endif
						</tr>
					</thead>
					<tbody>
						@foreach($doctors as $doctor)
						<tr>
							<td class="text-center">{{$loop->index +1}}</td>
							<td>{{$doctor->name}}</td>
							<td class="text-center">{{$doctor->phone}}</td>
							<td>{{$doctor->email}}</td>
							<td class="text-center">
								@if($doctor->status == 1)
								<button type="button" class="btn btn-padding btn-sm btn-success"><i class="fa fa-check-circle"></i> Available</button>
								@else
								<button type="button" class="btn btn-padding btn-sm btn-danger"><i class="fa fa-times-circle"></i> Not Available</button>
								@endif
							</td>
							<td class="text-center">
								<button class="btn btn-padding btn-sm btn-primary" type="button" onclick="doctor_details({{$doctor->id}})" data-toggle="modal" data-target="#doctor"><i class="fa fa-eye"></i></button>
							</td>
							@if(Auth::user()->role->name == "Agent")
							<td class="text-center">
								<a class="btn btn-padding btn-sm btn-info" href="{{Auth::user()->role->name == 'Agent' ? route('agent.appoint_by_doctor',$doctor->id) : route('doctor.appoint_by_doctor',$doctor->id)}}" target="_blank"><i class="fa fa-eye"></i></a>
							</td>
							@endif
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
		var doc_url;
		var auth = "{{Auth::user()->role->name}}";
		if (auth == "Agent") {
			doc_url = "{{url('/')}}/agent/doctor-details/"+id;
			console.log(doc_url);
		}else{
			doc_url = "{{url('/')}}/doctor/doctor-details/"+id;
			console.log(doc_url);
		}
		$("#doctordetails").empty();
		var male = 'Male';
		var female = 'Female';
		$.ajax({
			url: doc_url,
			method: "GET",
			success: function(data){
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
								'<button class="btn btn-padding btn-sm btn-block '+(data.status == 1 ? "btn-success":"btn-danger")+'">'+(data.status == 1 ? "Available":"Busy")+'</button>'+
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
			                                    '<td>'+data.chamber+'</td>'+
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