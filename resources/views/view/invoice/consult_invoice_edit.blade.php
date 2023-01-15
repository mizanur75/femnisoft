@extends('layouts.app')
@section('title','Edit Consultation Fee')

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
							<th>Amount</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="doctorByChamber">
						
						<tr>
							<form action="{{ route('doctor.consultationInvoiceEdited',$invoice->id)}}" class="sendrequest" method="POST">
								@csrf
								@method('PUT')
								<td class="text-center">
									<select class="form-control form-control-sm" style="height: 38px;" name="amount">
										<option selected="false" disabled>Select</option>
										<option value="00" {{$invoice->amount == '00' ? 'selected' : ''}}>00</option>
										<option value="20" {{$invoice->amount == '20' ? 'selected' : ''}}>20</option>
										<option value="40" {{$invoice->amount == '40' ? 'selected' : ''}}>40</option>
									</select>
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
	$('tbody').delegate('.invoice_fee','change', function(){
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
	$( "#invoice_date" ).datepicker({
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
		      'Please select a invoice date',
		    )
		  }
		})
	}

</script>
@endpush