@extends('layouts.app')
@section('title',$title)

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/mystyle.css')}}">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
		<div class="widget-area-2 proclinic-box-shadow search-box">
			<!-- <div class="float-right p-0" style="margin-top: -8px;"> -->
				<form action="{{route('doctor.search_lab_invoice_by_dr_date')}}" method="POST">
					<div class="row">
						@csrf
						<div class="col-md-3">
							<input type="text" name="start" id="start" style="height: 30px;" class="form-control form-control-sm" placeholder="Start Date" autocomplete="off">
						</div>
						<div class="col-md-3">
							<input type="text" name="finish" id="finish" style="height: 30px;" class="form-control form-control-sm" placeholder="End Date" autocomplete="off">
						</div>
						<div class="col-md-4">
							<select name="doctor_id" id="doctor_id" style="height: 30px;" class="form-control form-control-sm w-100" onchange="this.form.submit()">
								<option value="">Select Doctor</option>
								@foreach($doctors as $doctor)
								<option value="{{$doctor->id}}"> {{$doctor->user->name}}</option>
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
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Inv. No</th>
							<th>PT. ID</th>
							<th>PT. Type</th>
							<th>PT. Name</th>
							<th>Dr. Name</th>
							<th>Created at</th>
							<th>Amount(TK)</th>
							<th>Invoice(s)</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>

					<tfoot>
						<tr>
							<th colspan="7" style="text-align: right !important;">Total</th>
							<td class="text-center">{{$total}}/=</td>
							<td></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
<script>
	$(function(){
        $("#tableId").dataTable({
        	// "footerCallback": function ( row, data, start, end, display ) {
	        //     var api = this.api(), data;
	 
	        //     // Remove the formatting to get integer data for summation
	        //     var intVal = function ( i ) {
	        //         return typeof i === 'string' ?
	        //             i.replace(/[\$,]/g, '')*1 :
	        //             typeof i === 'number' ?
	        //                 i : 0;
	        //     };
	 
	        //     // Total over all pages
	        //     data = api.column( 4 ).data();
	        //     total = api
	        //         .column( 7 )
	        //         .data()
	        //         .reduce( function (a, b) {
	        //             return intVal(a) + intVal(b);
	        //         }, 0 );
	 
	        //     // Total over this page
	        //     pageTotal = api
	        //         .column( 7, { page: 'current'} )
	        //         .data()
	        //         .reduce( function (a, b) {
	        //             return intVal(a) + intVal(b);
	        //         }, 0 );
	 
	        //     // Update footer
	        //     $( api.column( 7 ).footer() ).html(
	        //         pageTotal +' ( '+ total +' Tk)'
	        //     );
	        // },
            "order": [[ 0, "desc" ]],
            lengthMenu: [[10, 20, 100, 500], [10, 20, 100, 500]],
            serverSide: true,
            ajax: {
                url: "{{route('doctor.invoice.index')}}",

                data: function (data) {
                    data.params = {
                        sac: "hello"
                    }
                }
            },
            buttons: true,
            processing: true,
            searching: true,
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_Row_Index' },
                {data: "id", name: 'id'},
                {data: "invoice_no", name: 'invoice_no'},
                {data: "centre_patient_id", name: 'centre_patient_id'},
                {data: "patient_type", name: 'patient_type'},
                {data: "patient_id", name: 'patient_id'},
                {data: "doctor_id", name: 'doctor_id'},
                {data: "created_at", name: 'created_at'},
                {data: "amount", name: 'amount'},
                {data: "invoice", name: 'invoice'}

            ],
            'columnDefs': [
                {"targets": 0, "className": "text-center"},
                {"targets": 1, "className": "text-center"},
                {"targets": 2, "className": "text-center"},
                {"targets": 3, "className": "text-center"},
                {"targets": 4, "className": "text-center"},
                {"targets": 5, "className": "text-center"},
                {"targets": 6, "className": "text-center"},
                {"targets": 7, "className": "text-center"},
                {"targets": 8, "className": "text-center"},
            ],
        });
    });
	$(function() {
		$( "#start" ).datepicker({
			dateFormat: 'dd-mm-yy'
		});
	});

	$(function() {
		$( "#finish" ).datepicker({
			dateFormat: 'dd-mm-yy'
		});
	});
</script>
@endpush