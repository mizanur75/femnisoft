@extends('layouts.app')
@section('title','Details of '.$patient->name)

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
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
</div>
<div class="row">
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right">

            <a href="{{ route('agent.seedoctor',$patient->id) }}"><button type="button" class="btn btn-padding btn-sm btn-info mb-3"><i class="fa fa-eye"></i> See Doctor</button></a>

        </div>
    </div>
	<!-- Widget Item -->
	<div class="col-md-3">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Patient Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong>Name</strong></td>
							<td>{{$patient->name}}</td>
						</tr>
						<tr>
							<td><strong>Age</strong> </td>
							<td>{{$patient->age}}</td>
						</tr>
						<tr>
							<td><strong>Gender</strong></td>
							<td>
								{{$patient->gender == 0 ? 'Male':'Female'}}
							</td>
						</tr>
						<tr>
							<td><strong>Phone </strong></td>
							<td>{{$patient->phone}}</td>
						</tr>
						<tr>
							<td><strong>Bloog Group</strong></td>
							<td>{{$patient->blood_group}}</td>
                        </tr>
						<tr>
							<td><strong>Address</strong></td>
							<td>{{$patient->address}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
	<div class="col-md-9">
		<div class="widget-area-2 proclinic-box-shadow">
			<button class="btn btn-padding btn-sm btn-info pull-right" data-toggle="modal" data-target="#addmodal"><i class="fa fa-plus"></i> Add New</button>
			<h3 class="widget-title">Generel Information</h3>
			<div class="table-responsive">
				<table id="infotable" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#SL</th>
							<th>Date</th>
							<th>BP</th>
							<th>Suger</th>
							<th>Pulse</th>
							<th>Temp</th>
							<th>Diabeties</th>
							<th>Injury</th>
							<th>Others</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($patientinfos as $info)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{date('d/m/y', strtotime($info->created_at))}}</td>
							<td>{{$info->blood_presure}}</td>
							<td>{{$info->blood_sugar}}</td>
							<td>{{$info->pulse}}</td>
							<td>{{$info->temp}}</td>
							<td>{{$info->diabeties}}</td>
							<td>{{$info->injury}}</td>
							<td>{{$info->others}}</td>
							<td class="text-center">
								<button type="button" data-toggle="modal" data-target="#editmodal" onclick="edit({{$info->id}})"><i class="fa fa-edit"></i></button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <!-- /Widget Item -->

	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">

			<h3 class="widget-title">Patient History</h3>
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Description</th>
							<th>Tests</th>
							<th>Check up Date</th>
							<th>Doctor Name</th>
							<th>Report(s)</th>
							<th>Prescription(s)</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($histories as $history)
							<tr>
								<td>{{$loop->index +1}}</td>
								<td>{{$history->description}}</td>
								<td class="text-center">
								@if($history->test == !null)
									{{$history->test}}
								@else
									<button class="btn btn-padding btn-sm btn-danger">Not suggested</button>
								@endif
								</td>
								<td class="text-center">{{date('d M Y', strtotime($history->created_at))}}</td>
								<td class="text-center">
									{{$history->name}}
									<p style="font-size: 11px;">{{$history->spcialist}}</p>
								</td>
								<td class="text-center">
									@if(\App\Model\Report::where('history_id',$history->id)->count() > 0)
									<a href="{{route('agent.history.show',$history->id)}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See</a>
									@else
                                        @if($history->test == !null)
									        <a href="{{route('agent.history.edit',$history->id)}}" class="btn btn-padding btn-sm btn-outline-info mb-0"><i class="fa fa-plus"></i> Add</a>
                                        @else
                                            <button class="btn btn-padding btn-sm btn-danger">No Report</button>
                                        @endif
									@endif
								</td>
								<td class="text-center">
									@if(\App\Model\Prescription::where('history_id',$history->id)->count() > 0)
									<a href="{{route('agent.prescription',$history->id)}}" class="btn btn-padding btn-sm btn-outline-info mb-0" target="_blank"><i class="fa fa-eye"></i> See </a>
									@else
									<button type="button" class="btn btn-padding btn-sm btn-outline-warning mb-0"><i class="fa fa-eye"></i> Not Ready</button>
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


<!-- Add Modal -->

<style>
	.modal-content {
	    border-radius: 5px;
	}
</style>

<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Input Patient Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('agent.patient-info.store') }}" method="POST">
      	@csrf
      	<input type="hidden" name="patient_id" value="{{$patient->id}}">
		<div class="modal-body">
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
						<label for="recipient-bp" class="col-form-label">BP</label>
						<input type="text" name="bp" class="form-control form-control-sm" id="recipient-bp">
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="recipient-suger" class="col-form-label">Suger</label>
						<input type="text" name="suger" class="form-control form-control-sm" id="recipient-suger">
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="recipient-pulse" class="col-form-label">Pulse</label>
						<input type="text" name="pulse" class="form-control form-control-sm" id="recipient-pulse">
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="recipient-temp" class="col-form-label">Temp.</label>
						<input type="text" name="temp" class="form-control form-control-sm" id="recipient-temp">
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="recipient-db" class="col-form-label">Diabeties</label>
						<input type="text" name="db" class="form-control form-control-sm" id="recipient-db">
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="recipient-injury" class="col-form-label">Injury</label>
						<input type="text" name="injury" class="form-control form-control-sm" id="recipient-injury">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="message-text" class="col-form-label">Others</label>
						<textarea class="form-control" name="others" id="message-text"></textarea>
					</div>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-padding btn-sm btn-primary">Save</button>
		</div>
      </form>
    </div>
  </div>
</div>
<!-- End Add Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" id="editappent">
	</div>
</div>
<!-- End Add Modal -->
@endsection


@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>


<script>
	function edit(id){
		$("#editappent").empty();
		$.ajax({
			url: "{{url('/')}}/agent/patient-info/"+ id,
			type: 'GET',
			success:function(data){
				$("#editappent").append(
				'<div class="modal-content">'+
			      '<div class="modal-header">'+
			        '<h5 class="modal-title" id="exampleModalLabel">Details of </h5>'+
			        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
			          '<span aria-hidden="true">&times;</span>'+
			        '</button>'+
			      '</div>'+
			      	'<form action="{{url('/')}}/agent/patient-info/'+ data.id +'" method="POST">'+
				      	'@csrf'+
				      	'@method("PUT")'+
				      	'<input type="hidden" name="patient_id" value="{{$patient->id}}">'+
						'<div class="modal-body">'+
							'<div class="row">'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-bp" class="col-form-label">BP</label>'+
										'<input type="text" value="'+data.blood_presure+'" name="bp" class="form-control form-control-sm" id="recipient-bp">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-suger" class="col-form-label">Suger</label>'+
										'<input type="text" value="'+data.blood_sugar+'" name="suger" class="form-control form-control-sm" id="recipient-suger">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-pulse" class="col-form-label">Pulse</label>'+
										'<input type="text" value="'+data.pulse+'" name="pulse" class="form-control form-control-sm" id="recipient-pulse">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-temp" class="col-form-label">Temp.</label>'+
										'<input type="text" value="'+data.temp+'" name="temp" class="form-control form-control-sm" id="recipient-temp">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-db" class="col-form-label">Diabeties</label>'+
										'<input type="text" value="'+data.diabeties+'" name="db" class="form-control form-control-sm" id="recipient-db">'+
									'</div>'+
								'</div>'+
								'<div class="col-sm-2">'+
									'<div class="form-group">'+
										'<label for="recipient-injury" class="col-form-label">Injury</label>'+
										'<input type="text" value="'+data.injury+'" name="injury" class="form-control form-control-sm" id="recipient-injury">'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="row">'+
								'<div class="col-sm-12">'+
									'<div class="form-group">'+
										'<label for="message-text" class="col-form-label">Others</label>'+
										'<textarea class="form-control" name="others" id="message-text">'+data.others+'</textarea>'+
									'</div>'+
								'</div>'+
							'</div>'+

						'</div>'+
						'<div class="modal-footer">'+
							'<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal">Close</button>'+
							'<button type="submit" class="btn btn-padding btn-sm btn-primary">Edit</button>'+
						'</div>'+
			        '</form>'+
			    '</div>'
				);
			}
		})
		
	};
	$('table').delegate('.remove','click', function(){
		$(this).parent().parent().remove();
	});
	$("#tableId").dataTable();
	$("#infotable").dataTable({
	    pageLength : 3,
	    lengthMenu: [[3, 10, 20, -1], [3, 10, 20, 'Todos']]
	});
</script>

@endpush
