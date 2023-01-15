@extends('layouts.app')
@section('title','Create Purchase Invoice')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
<style>
	.table td, .table th {
	    padding: .5rem;
	    border-top: 0px;
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
		<div class="widget-area-2 proclinic-box-shadow">
			<form action="{{ route('pharmacy.purchase.store') }}" method="POST" id="purchaseform">
				@csrf
				<div class="row">
					<div class="col-md-8">
						<select class="form-control-sm col-md-12 float-right mb-2 selectpicker show-tick medicine text-center" id="medicine_id" data-live-search="true">
							<option selected="false" disabled> Select Medicine </option>
							@foreach($medicines as $medicine)
							<option value="{{$medicine->id}}">{{$medicine->medname}}->{{$medicine->category}}->{{$medicine->mesname}}</option>
							@endforeach
						</select>
						<div class="table-responsive">
							<table class="table table-sm table-bordered" id="check">
								<thead>
									<tr class="text-center">
										<th class="text-left">M. Name</th>
										<th>UoM</th>
										<th>Qty</th>
										<th>Exp. Date</th>
										<th>Unite Price</th>
										<th>Discount</th>
										<th>Line Total</th>
										<th class="text-right">#</th>
									</tr>
								</thead>
								<tbody id="addnew">
									<tr>
										<td colspan="6"></td>
										<td class="total text-right pr-2 text-bold">0 /=</td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-4 table-responsive">
						<table class="table table-sm table-bordered">
							<tr>
								<td class="font-weight-bold">Company Name</td>
								<td>
									<select name="company_id" class="form-control form-control-sm selectpicker show-tick" data-live-search="true" required>
										<option selected="false"  disabled>Select Supplier</option>
										@foreach ($suppliers as $supplier)
											<option value="{{$supplier->id}}">{{$supplier->name}}</option>
										@endforeach
									</select>
								</td>
							</tr>
							<tr>
								<td class="font-weight-bold">Total Amount</td>
								<td><input type="text" name="total_amount" class="form-control-sm w-100 gtotal text-right" required readonly></td>
							</tr>
							<tr>
								<td class="font-weight-bold">Given Amount</td>
								<td><input type="number" name="given_amount" class="form-control-sm w-100 text-right" required></td>
							</tr>
							<tr>
								<td class="font-weight-bold">Payment Method</td>
								<td>
									<select name="payment_method" class="w-100 form-control-sm" required>
									<option selected="false"  disabled>Select Payment</option>
										<option value="1">Cash</option>
										<option value="2">Cheque</option>
									</select>
								</td>
							</tr>
								<td class="font-weight-bold">Comments</td>
								<td><input type="text" name="comments" class="form-control-sm w-100 expire_date"></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="submit" class="btn btn-padding btn-sm btn-primary float-right"><i class="fa fa-plus-circle"></i> Create</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
@endsection


@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>

<script>
	$('#medicine_id').change(function(){
		var medID = $(this).val();
		var token = $("input[name='_token']").val();
		$.ajax({
			url: "{{route('pharmacy.select_price')}}",
			method: "POST",
			type: "JSON",
			data: {medID: medID, _token:token},
			success: function (data) {
				console.log(data);
				var newrow = '<tr>'+
                        '<td>'+
							'<input type="text" value="'+data.medname+'" class="form-control-sm w-100" readonly>'+
							'<input type="hidden" name="cmbProductInfo[]" value="'+data.medicine_id+'" class="form-control-sm w-100" readonly>'+
							'<input type="hidden" name="category[]" value="'+data.type_id+'">'+
							'<input type="hidden" name="price_id[]" value="'+data.id+'">'+
						'</td>'+
						'<td>'+
						'<input type="text" value="'+data.mesname+'" class="form-control-sm w-100 uom" readonly>'+
						'<input type="hidden" name="uom[]" value="'+data.measurement_id+'" class="form-control-sm w-100 uom" id="uom">'+
						'</td>'+
						'<td><input type="number" name="qty[]" class="form-control-sm w-100 qty text-right" id="qty">'+
							'<input type="hidden" name="piece_qty[]" value="'+data.piece_qty+'" class="form-control-sm w-100 piece_qty text-right" id="piece_qty">'+
						'</td>'+
						'<td><input type="text" name="expire_date[]" class="form-control-sm w-100">'+
						'</td>'+
						'<td><input type="text" name="price[]" value="'+data.tp+'" class="form-control-sm w-100 price text-right" id="price" readonly></td>'+
						'<td><input type="text" name="dis[]" class="form-control-sm w-100 discount text-right" value="0"></td>'+
						'<td><input type="text" name="lineTotal[]" class="form-control-sm w-100 lineTotal text-right" readonly></td>'+
						'<td class="text-right"><button type="button" class="btn btn-padding btn-sm btn-danger remove" style="margin-bottom: 0px;"><i class="fa fa-times"></i> </button></td>'+
					'</tr>';
				// if ($('tbody [value="'+ data.id +'"]').length){
					$('#addnew').prepend(newrow);
				// }else {
				// 	Swal.fire("Sorry! You have already added this Medicine!");
				// 	$('#qty').focus();
				// }
				$("#qty").focus();
			}
		});
		
	});

	$('table').delegate('.remove','click', function(){
		$(this).parent().parent().remove();
		total();
	});
		$('tbody').delegate('.price, .qty, .discount','keyup',function(){
            var tr = $(this).parent().parent();
            var price = tr.find('.price').val();
            var qty = tr.find('.qty').val();
            var discount = tr.find('.discount').val();
            var lineTotal =((price * qty) - ((price * qty) * discount / 100));
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
	$(function() {
		$("#purchaseform").validate();
	})
	$("#tableId").dataTable();
</script>

@endpush