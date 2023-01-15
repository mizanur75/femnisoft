@extends('layouts.app')
@section('title','Create Invoice for '.$invoice_master->patient->name)

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
	<style>
		@media (max-width: 768px){
			.row{
				margin-left: 0px;
			}
			div[class*="col-"] {
			    padding-left: 0px;
			}
		}
	</style>
@endpush

@section('content')
<!-- <div class="row">
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
            <button type="button" class="btn btn-padding btn-sm btn-success"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
</div> -->
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
<div class="row bg-white mt-3">
	<div class="col-md-12 pt-3">
		<form action="{{route('doctor.invoice.update', $invoice_master->id)}}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<input type="hidden" name="patient_id" value="{{$invoice_master->patient_id}}">
			<input type="hidden" name="doctor_id" value="{{$invoice_master->doctor_id}}">
			<input type="hidden" name="history_id" value="{{$invoice_master->history_id}}">
			<div class="col-md-12 table-responsive">
				<label for="report" class="font-weight-bold"> Select Test Name</label>
				<select name="test_id" class="form-control-sm col-md-8 col-sm-12 float-right mb-2 selectpicker show-tick" id="test_id" data-live-search="true">
					<option selected="false" disabled> Select Test Name </option>
					@foreach($tests as $test)
					<option value="{{$test->id}}">{{$test->test_name}}</option>
					@endforeach
				</select>
				<table class="table table-sm table-bordered">
					<thead>
						<tr class="font-weight-bold text-center">
							<td>#SL</td>
							<td>Test Name</td>
							<td>Unit Cost</td>
							<td>Discount (Tk)</td>
							<td>Line Total</td>
							<td class="text-center">Action</td>
						</tr>
					</thead>
					<tbody id="addRow">
						@foreach($invoice_master->invoicedetails as $test)
							<tr>
	                            <td class="text-center">
	                                <input type="hidden" name="test_id[]" class="id" value="{{$test->test_id}}"/>{{$loop->index +1}}</td>
	                            <td>{{$test->test->test_name}}</td>
	                            <td class="text-right">
	                                <input type="text" name="unitcost[]" class="form-control form-control-sm unitcost text-right" value="{{$test->test->cost}}" readonly />
	                            </td>
	                            <td class="text-right">
	                            	<input type="number" name="discount[]" class="form-control form-control-sm discount text-right" placeholder="Tk" value="0" />
	                            </td>
	                            <td class="text-right">
	                            	<input type="text" name="lineTotal[]" class="form-control form-control-sm lineTotal text-right" value="{{$test->test->cost}}" readonly />
	                            </td>
	                            <td class="text-center">
	                                <button type="button" class="btn btn-sm btn-danger remove"><i class="fa fa-close"></i></button>
	                            </td>
	                        </tr>
                        @endforeach
                        <tr>
							<th colspan="4" class="text-right font-weight-bold">Total =</th>
							<td class="total text-right pr-2 text-bold"> 0 /=</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			<button type="submit" class="btn btn-sm btn-primary float-right mr-2 mb-2"><i class="fa fa-save"></i> Update </button>
		</form>
	</div>
</div>
@endsection


@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>
<script>
	$(function(){
		$("#test_id").change(function() {
			var id = $(this).val();
			$.ajax({
				url: "{{route('doctor.selectTest')}}",
				method: "POST",
				dataType: "JSON",
				data: {'id':id, _token: "{{csrf_token()}}"},
				success: function(test){

					var newRow = '<tr>'+
                                        '<td class="text-center">'+
                                            '<input type="hidden" name="test_id[]" class="id" value="'+ test.id +'"/>'+ test.id +'</td>'+
                                        '<td>'+ test.test_name +'</td>'+
                                        '<td class="text-center">'+
                                        '<input type="text" name="unitcost[]" class="form-control form-control-sm unitcost text-right" value="'+test.cost+'" readonly />'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="number" name="discount[]" class="form-control form-control-sm discount text-right" placeholder="Tk" value="0"/>'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" name="lineTotal[]" class="form-control form-control-sm lineTotal text-right" value="'+test.cost+'" readonly />'+
                                        '</td>'+
                                        '<td class="text-center">'+
                                            '<button type="button" class="btn btn-sm btn-danger remove"><i class="fa fa-close"></i></button>'+
                                        '</td>'+
                                '</tr>';
					if ($("tbody [value='"+test.id+"']").length < 1){
							$("#addRow").prepend(newRow);
					}else {
						Swal.fire("Sorry! You have already added this Test!");
						$('#result').focus();
					}
					$('#result').focus();
				}
			})
		});
	});
	$('table').delegate('.remove','click', function(){
		$(this).parent().parent().remove();
		total();
	});
	$('tbody').delegate('.price, .qty, .discount','keyup',function(){
        var tr = $(this).parent().parent();
        var price = tr.find('.unitcost').val();
        var discount = tr.find('.discount').val();
        // var lineTotal =(price - (price * discount / 100));
        
        var lineTotal =(price - discount);
        tr.find('.lineTotal').val(lineTotal);
        total();
    });

    function total(){
        var total = 0;
        $('.lineTotal').each(function(){
            var amount = $(this).val() -0;
            total += amount;
        });

	    $('.total').html(total +' /=');
	    $('.gtotal').val(total);
    }
</script>
<script>
	$("#tableId").dataTable();
</script>

@endpush
