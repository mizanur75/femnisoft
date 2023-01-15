@extends('layouts.app')
@section('title','Choose Your Doctor')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<style>
select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 100%;
}
.swal2-cancel{
	margin-right: 40px !important;
}
</style>
<script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>

@endpush


@section('content')

<div class="row">
	<!-- Widget Item -->
	<!-- <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
        	<div class="row">
				<div class="col-md-4">
					<label for="chamber_id" class="font-weight-bold text-danger">Please Select Your Doctor Chamber:</label>
				</div>
				<div class="col-md-8">
					<select name="chamber_id" class="form-control form-control-sm" id="chamber_id">
						<option selected="false" disabled>Select Work Station</option>
						@foreach($chambers as $chamber)
						<option value="{{$chamber->id}}">{{$chamber->name}}, {{$chamber->address}}-{{$chamber->post_code}}</option>
						@endforeach
					</select>
				</div>
			</div>
        </div>
    </div> -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<div class="table-responsive">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Image</th>
							<th>Name</th>
							<th>Education</th>
							<th>Title</th>
							<th>Speciality</th>
							<th style="width: 7%;">Fee (TK)</th>
							<th style="width: 11%;">Appoint Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="doctorByChamber">

					@foreach($doctors as $doctor)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td><img src="{{asset('images/doctor/'.$doctor->image)}}" style="width: 100px; height: auto; border-radius: 50%;" alt="{{$doctor->name}}"></td>
							<td>{{$doctor->name}}</td>
							<td>{{$doctor->education}}</td>
							<td>{{$doctor->title}}</td>
							<td>{{$doctor->specialist}}</td>
							<form action="{{ route('doctor.sendrequest',['doctor_id'=>$doctor->id, 'patient_id'=>$patient->id]) }}" class="sendrequest" method="GET" id="selectdate{{$doctor->id}}">
								@csrf
                                <input type="hidden" name="patient_info_id" value="{{$patient_info->id}}">
								<td>
									<select class="form-control form-control-sm appoint_fee" style="height: 38px;" name="appoint_fee">
										<option selected="false" disabled>Select</option>
										<option value="0">00</option>
										<option value="30">30</option>
										<option value="50">50</option>
									</select>
								</td>
								<td class="text-center">
									<input type="text" class="form-control form-control-sm" id="datepicker{{$doctor->id}}" name="appoint_date" autocomplete="off">
								</td>
								<script>
								$( function() {
									$( "#datepicker{{$doctor->id}}" ).datepicker({
										dateFormat: 'dd-mm-yy',
										minDate: 0
									});
								} );
								</script>
								<td class="text-center">
								<button type="button" onclick="selectdate('{{$doctor->id}}')" id="{{$doctor->id}}" class="btn btn-danger btn-sm d-none"><i class="fa fa-paper-plane" value="2"></i> Ok</button>
								</td>
							</form>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>

<script>
	$('tbody').delegate('.appoint_fee','change', function(){
		var fee = $(this).val();
	    var tr = $(this).parent().parent();
		if (fee >= 0) {
	    	tr.find('button').removeClass('d-none');
		}else{
			tr.find('button').addClass('d-none');
		}
	});
</script>
<script>
	function selectdate(id){
		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: false,

		  allowOutsideClick: false
		})

		swalWithBootstrapButtons.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes',
		  cancelButtonText: 'No',
		  reverseButtons: true,
		  allowOutsideClick: false
		}).then((result) => {
		  if (result.value) {
		    event.preventDefault();
		    document.getElementById('selectdate'+id).submit();
		  } else if (
		    /* Read more about handling dismissals below */
		    result.dismiss === Swal.DismissReason.cancel
		  ) {
		    swalWithBootstrapButtons.fire(
		      'Please select a appoint date',
		    )
		  }
		})
	}

</script>
<script>
	// $(function(){
	// 	var html = '<tr style="background-color: #f3baba;">'+
	// 			'<td colspan="7" class="text-center font-weight-bold"><h3>Please Select Your Doctor Chamber</h3></td>'+
	// 		'</tr>';
	// 	$("#doctorByChamber").append(html);
	// });

	// $("#chamber_id").change(function(){
	// 	$("#doctorByChamber").empty();
	// 	var chamber_id = $(this).val();
	// 	$.ajax({
	// 		url: '{{route("agent.doctorByChamber")}}',
	// 		method: 'POST',
	// 		data:{chamber_id: chamber_id, _token: '{{csrf_token()}}'},
	// 		success: function(data){
	// 			if (data.length > 0) {
	// 				$.each(data, function(index, value){
	// 					var html = '<tr>'+
	// 						'<td>'+(index +1) +'</td>'+
	// 						'<td><img src="/images/doctor/'+value.image+'" style="width: 100px; height: auto; border-radius: 50%;" alt="{{$doctor->name}}"></td>'+
	// 						'<td>'+value.name+'</td>'+
	// 						'<td>'+value.education+'</td>'+
	// 						'<td>'+value.title+'</td>'+
	// 						'<td>'+value.specialist+'</td>'+
	// 						'<td class="text-center">'+
	// 						'<a href="{{url("/")}}/agent/patient-send-doctor-request/'+value.id+'/{{$patient->id}}" class="btn btn-danger btn-sm"><i class="fa fa-paper-plane"></i> Send Request</a>'+
	// 						'</td>'+
	// 					'</tr>';
	// 					$("#doctorByChamber").append(html);
	// 				});
	// 			}else{
	// 				var html = '<tr style="background-color: #f3baba;">'+
	// 						'<td colspan="7" class="text-center font-weight-bold"><h3>Sorry! No Doctor Available</h3></td>'+
	// 					'</tr>';
	// 				$("#doctorByChamber").append(html);
	// 			}

	// 		}
	// 	});
	// });

	$("#tableId").dataTable();
</script>
@endpush
