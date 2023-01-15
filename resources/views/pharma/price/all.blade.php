@extends('layouts.app')
@section('title','Pricing')

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
	<!-- Widget Item -->
	<div class="col-md-12">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endif
		@if(Session::has('danger'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('danger') }}</strong>
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
		<div class="widget-area-2 proclinic-box-shadow">
			<form action="{{route('pharma.price.store')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="form-row">
					<div class="form-group col-md-3">
						<label for="Test-name">Select Type/Formulation</label> <span class="text-danger">*</span>
						<select name="type_id" class="form-control form-control-sm bg-green float-right selectpicker show-tick" id="type_id" data-live-search="true">
							<option selected="false" disabled>Select Type/Formulation</option>
							@foreach($categories as $category)
							<option value="{{$category->id}}">{{$category->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="Test-name">Select Med./Trade Name</label> <span class="text-danger">*</span>
						<select name="medicine_id" class="form-control form-control-sm bg-green float-right selectpicker show-tick" id="medicine_id" data-live-search="true">
							<option selected="false" disabled>Select Med./Trade Name</option>
							@foreach($medicines as $medicine)
							<option value="{{$medicine->id}}">{{$medicine->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="dob">Measurement/Dosage</label> <span class="text-danger">*</span>
						<select name="uom_id" class="form-control form-control-sm float-right selectpicker show-tick" id="uom_id" data-live-search="true">
							<option selected="false" disabled> Select Meas./Dosage</option>
							@foreach($measurements as $measurement)
							<option value="{{$measurement->id}}">{{$measurement->measurement}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="">Status</label> <span class="text-danger">*</span>
						<div>
							<input type="radio" id="active" name="status" class="form-control-sm" value="0">
							<label for="active">Active</label>
						</div>
						<div>
							<input type="radio" name="status" class="form-control-sm" value="1">
							<label for="active">Deactive</label>
						</div>
					</div>
					<!-- <div class="form-group col-md-2">
						<label for="Test-name">TP Rate</label> <span class="text-danger">*</span> -->
						<input type="hidden" name="tprate" class="w-100 form-control-sm" style="line-height: 32px;" value="0">
					<!-- </div> -->
					<!-- <div class="form-group col-md-1">
						<label for="Test-name">MRP Rate</label> <span class="text-danger">*</span> -->
						<input type="hidden" name="mrprate" class="w-100 form-control-sm" style="line-height: 32px;" value="0">
					<!-- </div>
					<div class="form-group col-md-2">
						<label for="Wholesale">Wholesale Rate</label> <span class="text-danger">*</span> -->
						<input type="hidden" name="wholesale" class="w-100 form-control-sm" style="line-height: 32px;" value="0">
					<!-- </div> -->
					<div class="form-group col-md-1 text-right" style="margin-top: 30px;">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</button>
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
							<th>Type/Formulation</th>
							<th>Generic Name</th>
							<th>Medicine/Trade Name</th>
							<th>UoM/Dosage</th>
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


