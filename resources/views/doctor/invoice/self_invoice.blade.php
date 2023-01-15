@extends('layouts.app')
@section('title','Self Invoice')

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
</div>
<div class="row bg-white mt-3">
	<div class="col-md-12 pt-3">
		<form action="{{route('agent.invoice.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="history_id" value="0">
			
			<div class="col-md-12 table-responsive">
				<div class="row">
					<div class="col-md-3">
						<label for="ecoh_id" class="font-weight-bold col-md-4"> PT. ID</label>
						<input type="text" name="ecoh_id" class="form-control-sm float-right col-md-8 mb-2" required>
					</div>
					<div class="col-md-4">
						<label for="doctor_id" class="font-weight-bold col-md-4"> Referred By</label>
						<select name="doctor_id" class="form-control-sm float-right col-md-8 mb-2">
							<option selected="false" disabled> Select </option>
							<option value="0"> Self </option>
							@foreach($doctors as $doctor)
							<option value="{{$doctor->id}}">{{$doctor->user->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-5">
						<label for="report" class="font-weight-bold col-md-4"> Select Test Name</label>
						<select name="test_id" class="form-control-sm float-right col-md-8 mb-2 selectpicker show-tick" id="test_id" data-live-search="true">
							<option selected="false" disabled> Select Test Name </option>
							@foreach($tests as $test)
							<option value="{{$test->id}}">{{$test->test_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
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
                        <tr>
							<th colspan="4" class="text-right font-weight-bold">Total =</th>
							<td class="total text-right pr-2 text-bold"> 0 /=</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			<button type="submit" class="btn btn-sm btn-primary float-right mr-2 mb-2"><i class="fa fa-save"></i> Create </button>
			
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
				url: "{{route('agent.selectTest')}}",
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
                                            '<input type="number" name="discount[]" class="form-control form-control-sm discount text-right"/>'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" name="lineTotal[]" class="form-control form-control-sm lineTotal text-right" readonly />'+
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
