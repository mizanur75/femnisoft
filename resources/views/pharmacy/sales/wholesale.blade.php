@extends('layouts.app')
@section('title','Wholesale Order')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/mystyle.css')}}">
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
			<form action="{{ route('pharmacy.sale.store') }}" method="POST" id="orderform">
				@csrf
				<div class="row">
					<div class="col-md-8 col-sm-8 col-lg-8 table-responsive">
						<select class="form-control-sm w-100 col-md-12 float-right mb-2 selectpicker show-tick medicine" id="medicine_id" data-live-search="true">
							<option selected="false" disabled class="text-center"> Select Medicine </option>
							@foreach($medicines as $medicine)
							<option value="{{$medicine->id}}">{{$medicine->medname}} -> {{$medicine->category}} -> {{$medicine->mesname}} == {{$medicine->qty}}</option>
							@endforeach
						</select>
						<table class="table table-sm table-bordered">
							<thead>
								<tr class="text-center">
									<th class="text-left">M. Name</th>
									<th>UoM</th>
									<th>Qty</th>
									<th>Unite Price</th>
									<th>Discount</th>
									<th>Line Total</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody id="tbody">
								<tr>
									<td colspan="5"></td>
									<td class="total text-right pr-2 text-bold">0 /=</td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-4 col-sm-4 col-lg-4 table-responsive">
						<table class="table table-sm table-bordered">
							<tr>
								<td class="font-weight-bold">Customer Name</td>
								<td>
									<select name="customer_id" class="form-control form-control-sm select2" id="customer_id" required>
										<option selected="false"  disabled>Select Customer</option>
										@foreach ($customers as $customer)
											<option value="{{$customer->id}}">{{$customer->phone}}</option>
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
							<tr>
								<td class="font-weight-bold">Comments</td>
								<td><input type="text" name="comments" class="form-control-sm w-100"></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="row"></div>
				
				<div class="text-right">
					<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Create</button>
				</div>
			</form>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
<div class="modal fade" id="customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title bold" id="exampleModalLabel">Input Customer Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action=" {{ route('pharmacy.add') }}" method="POST">
	      @csrf
	      <div class="modal-body">
	      	<label for="" class="bold">Name</label>
	      	<input type="text" name="customer" class="form-control form-control-sm" placeholder="Input Customer Name">
	      	<div class="mt-2">
	      	<label for="" class="bold">Phone</label>
	      		<input type="text" name="phone" class="form-control form-control-sm" placeholder="Input Customer Phone Number">
	      	</div>
	      	<div class="mt-2">
	      	<label for="" class="bold">Address</label>
	      		<input type="text" name="address" class="form-control form-control-sm" placeholder="Input Customer Address">
	      	</div>
	      	<div for="">Status</div>
	        <div class="form-check form-check-inline">
	          <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1">
	          <label class="form-check-label" for="inlineRadio1">Active</label>
	        </div>
	        <div class="form-check form-check-inline">
	          <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
	          <label class="form-check-label" for="inlineRadio2">Deactive</label>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-plus"></i> Add</button>
	      </div>
  		</form>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>
<script src="{{asset('js/select2.full.js')}}"></script>
<script>
	$('.select2').select2({
      theme: 'bootstrap4'
    });
</script>
<script>
	//================ Load  Modal ===========
	function showModal(){
		$('span[dir="ltr"]').addClass('none');
		$('#customer').modal('show');
	}

	//================ Load  All Customer ===========
	function loadCustomer(){
		$.ajax({
			url: "{{route('pharmacy.loadCustomer')}}",
			method: "GET",
			type: "JSON",
			success: function(data){
				var customers = data.customers;
				$.each(customers, function(key, value) {
					$('.typeahead').append('<option value="'+value.id+'">'+value.phone+'</option>')
				});
			}
		});		
	}

//================ Load  unit of measurement by medicine ===========

	$("#medicine_id").change(function(){
		var medID = $(this).val();
		var token = $("input[name='_token']").val();
		$.ajax({
			url: "{{route('pharmacy.wholesaleprice')}}",
			method: "POST",
			type: "JSON",
			data: {medID: medID, _token:token},
			success: function (data) {
				var newrow = '<tr>'+
						'<td>'+
						'<input type="hidden" name="cmbProductInfo[]" value="'+data.medicine_id+'">'+
						'<input type="hidden" name="stock[]" value="'+data.id+'">'+
						'<input type="text" value="'+data.medname+'" class="form-control-sm w-100" readonly>'+
						'</td>'+
						'<td>'+
						'<input type="hidden" name="uom[]" value="'+data.uom_id+'">'+
						'<input type="text" class="form-control-sm w-100 uom" id="uom" value="'+data.mesname+'" readonly>'+
						'</td>'+
						'<td>'+
						'<input type="number" name="qty[]" class="form-control-sm w-100 qty text-right" id="qty">'+
						'<input type="hidden" class="checkqty" value="'+data.qty+'" id="checkqty">'+
						'<input type="hidden" name="piece_qty[]" value="'+data.piece_qty+'" id="piece_qty" class="pqty">'+
						'</td>'+
						'<td><input type="text" name="price[]" class="form-control-sm w-100 price text-right" id="price" readonly value="'+data.price+'">'+
							'<input type="hidden" name="tp[]" value="'+data.tp+'" id="tp">'+
						'</td>'+
						'<td><input type="text" name="dis[]" class="form-control-sm w-100 discount text-right" value="0"></td>'+
						'<td><input type="text" name="lineTotal[]" class="form-control-sm w-100 lineTotal text-right" id="lineTotal" readonly></td>'+
						'<td class="text-right"><button type="button" class="btn btn-padding btn-sm btn-danger btn-padding remove" style="margin-bottom: 0px;"><i class="fa fa-times"></i> </button></td>'+
					'</tr>';
				$('#tbody').prepend(newrow);
				$("#qty").focus();
			}
		});
	});

//================ Load  Price by medicine and unit of measurement ===========

	// $('table').delegate('.uom','change', function(){
	// 	var tr = $(this).parent().parent();
	// 	var medID = tr.find('.medicine').val();
	// 	var uom_id = tr.find('.uom').val();
	// 	var token = $("input[name='_token']").val();
	// 	$.ajax({
	// 		url: "{{route('pharmacy.price')}}",
	// 		method: "POST",
	// 		type: "JSON",
	// 		data: {medID: medID, uom_id: uom_id, _token:token},
	// 		success: function (data) {
	// 			console.log(data);
	// 			var price = data.data.price;
	// 			var tp = data.data.tp;
	// 			var piece_qty = data.data.piece_qty;
	// 			var qty = data.data.qty;
	// 			if (qty > 0) {
	// 				$('#price').val(price);
	// 				$('#tp').val(tp);
	// 				$('#piece_qty').val(piece_qty);
	// 				$('#checkqty').val(qty);
	// 				$("#qty").focus();
	// 			}else{
	// 				Swal.fire("Sorry! No Quantity Available!");
	// 			}
	// 		}
	// 	});
	// });

//================ On click add new row ===========

	function addRow(){
		var newrow = '<tr>'+
						'<td>'+
						'<select name="cmbProductInfo[]" class="form-control-sm w-100 medicine">'+
							'<option selected="false" disabled> Select Medicine </option>'+
							'@foreach($medicines->unique() as $medicine)'+
							'<option value="{{$medicine->id}}"> {{$medicine->medname}} </option>'+
							'@endforeach'+
						'</select>'+
						'</td>'+
						'<td><select name="uom[]" class="form-control-sm w-100 uom" id="uom"></select></td>'+
						'<td>'+
						'<input type="number" name="qty[]" class="form-control-sm w-100 qty text-right" id="qty">'+
						'<input type="hidden" class="checkqty" id="checkqty">'+
						'<input type="hidden" name="piece_qty[]" id="piece_qty" class="pqty">'+
						'</td>'+
						'<td><input type="text" name="price[]" class="form-control-sm w-100 price text-right" id="price" readonly>'+
							'<input type="hidden" name="tp[]" id="tp">'+
						'</td>'+
						'<td><input type="text" name="dis[]" class="form-control-sm w-100 discount text-right" value="0"></td>'+
						'<td><input type="text" name="lineTotal[]" class="form-control-sm w-100 lineTotal text-right" id="lineTotal" readonly></td>'+
						'<td class="text-right"><button type="button" class="btn btn-padding btn-sm btn-danger remove" style="margin-bottom: 0px;"><i class="fa fa-times"></i> </button></td>'+
					'</tr>';
		$('#tbody').prepend(newrow);
	}
	//================ Remove a row ===========

	$('table').delegate('.remove','click', function(){
		$(this).parent().parent().remove();
		total();
	});

	//================ Calculate Total ===========
		$('tbody').delegate('.price, .qty, .discount','keyup',function(){
            var tr = $(this).parent().parent();
            var price = tr.find('.price').val();
            var qty = parseFloat(tr.find('.qty').val());
            var checkqty = parseFloat(tr.find('.checkqty').val());
            var discount = tr.find('.discount').val();
            var lineTotal =((price * qty) - ((price * qty) * discount / 100));
            console.log(typeof(qty));
            console.log(checkqty);
            if ( parseFloat(qty) > parseFloat(checkqty) ) {
            	Swal.fire("Sorry! Quantity Exceed " +parseFloat(checkqty));
            	$("#price").empty();
            	$("#lineTotal").empty();
            	$("#qty").empty();
            }else{
	            tr.find('.lineTotal').val(lineTotal);
	            total();
            }
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
		$("#orderform").validate();
	})
	// $("#tableId").dataTable();
</script>

@endpush