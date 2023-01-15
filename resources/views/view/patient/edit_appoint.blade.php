@extends('layouts.app')
@section('title','Edit Appoint')

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
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<div class="table-responsive">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>Doctor Name</th>
							<th>Appoint Date</th>
							<th>Today's Serial No.</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="doctorByChamber">
						
						<tr>
							<form action="{{ route('agent.appoint_edited')}}" class="sendrequest" method="POST">
								@csrf
								<input type="hidden" name="appoint_id" value="{{$appoint->id}}">
								<td class="text-center">
									<select class="form-control form-control-sm" style="height: 38px;" name="doctor_id">
										<option selected="false" disabled>Select</option>
										@foreach($doctors as $doctor)
										<option value="{{$doctor->id}}" {{$appoint->doctor_id == $doctor->id ? 'selected' : ''}}>{{$doctor->user->name}}</option>
										@endforeach
									</select>
								</td>
								<td class="text-center">
									<input type="text" class="form-control form-control-sm" id="appoint_date" name="appoint_date" autocomplete="off" value="{{$appoint->appoint_date}}">
								</td>
								<td>@if($appoint->appoint_date == \Carbon\Carbon::parse()->format('d-m-Y'))
									<input type="number" class="form-control form-control-sm" name="serial_no" autocomplete="off" value="{{$appoint->serial_no == null ? $serial : $appoint->serial_no}}" placeholder="Input Today's Serial Only">
									@else
									<input type="number" class="form-control form-control-sm" name="serial_no" autocomplete="off" value="{{$appoint->serial_no}}" placeholder="Input Today's Serial Only">
									@endif
								</td>
								<td class="text-center">
								<button type="submit" class="btn btn-info btn-sm"><i class="fa fa-sync"></i> Update</button>
								</td>
							</form>
						</tr>
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
$( function() {
	$( "#appoint_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		minDate: 0
	});
} );
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
@endpush