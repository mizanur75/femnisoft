@extends('layouts.app')
@section('title','Edit Pricing')

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
</style>
@endpush


@section('content')
<div class="row">
	@if(Session::has('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ Session::get('success') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	@endif

	@if($errors->any())
		@foreach($errors->all() as $error)
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Opps!</strong> {{$error}}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endforeach
	@endif
	<!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<form action="{{route('pharma.price.update', $price->id)}}" method="POST" enctype="multipart/form-data">
				@csrf
                @method('PUT')
				<div class="form-row">
					<div class="form-group col-md-3">
						<label for="Test-name">Select Type/Formulation</label> <span class="text-danger">*</span>
						<select name="type_id" class="form-control form-control-sm bg-green float-right selectpicker show-tick" id="type_id" data-live-search="true">
							<option selected="false" disabled>Select Type/Formulation</option>
							@foreach($categories as $category)
							<option value="{{$category->id}}" {{$price->type_id == $category->id?'selected':''}}>{{$category->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="Test-name">Select Medicine</label> <span class="text-danger">*</span>
						<select name="medicine_id" class="form-control form-control-sm bg-green float-right mb-2 selectpicker show-tick" id="medicine_id" data-live-search="true">
							<option selected="false" disabled>Select Med./Trade Name</option>
							@foreach($medicines as $medicine)
							<option value="{{$medicine->id}}" {{$price->medicine_id == $medicine->id?'selected':''}}>{{$medicine->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="dob">Unit of Meas/Dosage</label> <span class="text-danger">*</span>
						<select name="uom_id" class="form-control form-control-sm float-right mb-2 selectpicker show-tick" id="uom_id" data-live-search="true">
							<option selected="false" disabled> Select Unit of Measurement/Dosage</option>
							@foreach($measurements as $measurement)
							<option value="{{$measurement->id}}" {{$price->measurement_id == $measurement->id?'selected':''}}>{{$measurement->measurement}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="">Status</label> <span class="text-danger">*</span>
						<div>
							<input type="radio" id="active" name="status" class="form-control-sm" value="0" {{$price->status == 0 ? 'checked' : ''}}>
							<label for="active">Active</label>
						</div>
						<div>
							<input type="radio" id="deactive" name="status" class="form-control-sm" value="1" {{$price->status == 1 ? 'checked' : ''}}>
							<label for="deactive">Deactive</label>
						</div>
					</div>
					<!-- <div class="form-group col-md-2">
						<label for="Test-name">TP Rate</label> <span class="text-danger">*</span> -->
						<input type="hidden" name="tprate" class="w-100 form-control-sm" value="{{$price->tp}}" style="line-height: 32px;">
					<!-- </div>
					<div class="form-group col-md-1">
						<label for="Test-name">MRP Rate</label> <span class="text-danger">*</span> -->
						<input type="hidden" name="mrprate" class="w-100 form-control-sm" value="{{$price->mrp}}" style="line-height: 32px;">
					<!-- </div> -->
					<!-- <div class="form-group col-md-2">
						<label for="Wholesale">Wholesale Rate</label> <span class="text-danger">*</span> -->
						<input type="hidden" name="wholesale" class="w-100 form-control-sm" style="line-height: 32px;" value="{{$price->wholesale}}">
					<!-- </div> -->
					<div class="form-group col-md-1 text-right" style="margin-top: 30px;">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-refresh"></i> Update</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">			
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#SL</th>
							<th>Category</th>
							<th>Generic Name</th>
							<th>Medicine Name</th>
							<th>UoM</th>
							<th>Status</th>
							<!-- <th>Qty</th>
							<th>TP Rate</th>
							<th>MRP Rate</th>
							<th>Wholesale Rate</th> -->
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$(function(){
        $("#tableId").dataTable({
            "order": [[ 0, "desc" ]],
            pageLength : 20,
            lengthMenu: [[20, 100, 500], [20, 100, 500]],
            serverSide: true,
            ajax: {
                url: "{{route('pharma.price.index')}}",

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
                {data: "category", name: 'category'},
                {data: "gen", name: 'gen'},
                {data: "mname", name: 'mname'},
                {data: "mes", name: 'mes'},
                {data: "status", name: 'status'},
                // {data: "qty", name: 'qty'},
                // {data: "tp", name: 'tp'},
                // {data: "mrp", name: 'mrp'},
                // {data: "wholesale", name: 'wholesale'},
                {data: "action", name: 'wholesale'},

            ],
            'columnDefs': [
                {"targets": 0, "className": "text-center"},
                {"targets": 1, "className": "text-center"},
                {"targets": 2, "className": "text-center"},
                {"targets": 3, "className": "text-center"},
                {"targets": 4, "className": "text-center"},
                {"targets": 5, "className": "text-center"},
                {"targets": 6, "className": "text-center"},
                // {"targets": 7, "className": "text-center"},
                // {"targets": 8, "className": "text-center"},
                // {"targets": 9, "className": "text-center"},
            ],
        });
    });
</script>
@endpush


