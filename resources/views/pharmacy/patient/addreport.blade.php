@extends('layouts.app')
@section('title','Add Report for '.$patient->name)

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
@endpush


@section('content')
<div class="row bg-white mt-3">
	<div class="col-md-12 pt-3">
		<form action="{{route('agent.history.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="history_id" value="{{$history->id}}">
			<div class="col-md-12 table-responsive" style="min-height: 300px;">
				<label for="report">Add Reports</label>
				<select name="test_id" class="form-control-sm col-md-8 float-right mb-2 selectpicker show-tick" id="test_id" data-live-search="true">
					<option selected="false" disabled> ================== Select Test Name================ </option>
					@foreach($tests as $test)
					<option value="{{$test->id}}">{{$test->test_name}}</option>
					@endforeach
				</select>
				<table class="table table-sm table-bordered">
					<thead>
						<tr>
							<td>#SL</td>
							<td>Test Name</td>
							<td>Normal Value</td>
							<td>Result</td>
							<td>Remark</td>
							<td>Image</td>
							<td class="text-center">Action</td>
						</tr>
					</thead>
					<tbody id="addRow">
					</tbody>
				</table>
			</div>
			<button type="submit" class="btn btn-sm btn-primary float-right mr-2 mb-2"><i class="fa fa-plus"></i> Add </button>
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
                                        '<td class="text-center">'+ test.default_value +'</td>'+
                                        '<td>'+
                                            '<input type="text" name="result[]" class="form-control form-control-sm" id="result"/></td>'+
                                        '<td>'+
                                            '<input type="text" name="remark[]" class="form-control form-control-sm" id="remark"/></td>'+
                                        '<td>'+
                                            '<input type="file" name="image[]" class="form-control form-control-sm"/></td>'+
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
	});
</script>
<script>
	$("#tableId").dataTable();
</script>

@endpush
