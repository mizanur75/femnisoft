@extends('layouts.app')
@section('title','Details of '.$patient->name)

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
@endpush


@section('content')
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Patient Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>											
							<td><strong>Name</strong></td>
							<td>{{$patient->name}}</td>
						</tr>
						<tr>
							<td><strong>Age</strong> </td>
							<td>{{$patient->age}}</td>
						</tr>
						<tr>
							<td><strong>Gender</strong></td>
							<td>
								{{$patient->gender == 0 ? 'Male':'Female'}}
							</td>
						</tr>
						<tr>
							<td><strong>Phone </strong></td>
							<td>{{$patient->phone}}</td>
						</tr>
						<tr>
							<td><strong>Email</strong></td>
							<td>{{$patient->email}}</td>
                        </tr>
						<tr>
							<td><strong>Address</strong></td>
							<td>{{$patient->address}}</td>
						</tr>								
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Generel Information</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>											
							<td><strong>Bloog Group</strong></td>
							<td>{{$patient->blood_group}}</td>
						</tr>
						<tr>
							<td><strong>Bloog Presure</strong> </td>
							<td>{{$patient->blood_presure}}</td>
						</tr>
						<tr>
							<td><strong>Bloog Suger</strong></td>
							<td>
								{{$patient->blood_suger}}
							</td>
						</tr>
						<tr>
							<td><strong>Pulse </strong></td>
							<td>{{$patient->pulse}}</td>
						</tr>
						<tr>
							<td><strong>Injury</strong></td>
							<td>{{$patient->injury}}</td>
                        </tr>
						<tr>
							<td><strong>Address</strong></td>
							<td>{{$patient->address}}</td>
						</tr>								
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <!-- /Widget Item -->

	{{-- <div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">			
            <div class="row">
            	<div class="col-md-6">
            		<button type="button" class="btn btn-success btn-block mb-3"><span class="ti-pencil-alt"></span> Edit Patient</button>
            	</div>
            	<div class="col-md-6">
            		<button type="button" class="btn btn-danger btn-block mb-3"><span class="ti-trash"></span> Delete Patient</button>
            	</div>
            </div>
            
		</div>
	</div> --}}
     <!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<button class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Add History</button>
			<h3 class="widget-title">Patient History</h3>
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="text-center">										
							<th>Date</th>
							<th>Cost</th>
							<th>Discount</th>
							<th>Payment Type</th>
							<th>Invoive</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>											
							<td>12-03-2018</td>
							<td>$300</td>
							<td>15%</td>
							<td>Check</td>
							<td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
							<td><span class="badge badge-warning">Pending</span></td>
                        </tr>
                        <tr>											
							<td>12-03-2018</td>
							<td>$130</td>
							<td>5%</td>
							<td>Credit Card</td>
							<td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
							<td><span class="badge badge-success">Completed</span></td>
                        </tr>
                        <tr>											
							<td>12-03-2018</td>
							<td>$30</td>
							<td>5%</td>
							<td>Credit Card</td>
							<td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
							<td><span class="badge badge-danger">Cancelled</span></td>
                        </tr>
                        <tr>											
							<td>12-03-2018</td>
							<td>$30</td>
							<td>5%</td>
							<td>Cash</td>
							<td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
							<td><span class="badge badge-success">Completed</span></td>
                        </tr>
                        <tr>											
							<td>12-03-2018</td>
							<td>$30</td>
							<td>5%</td>
							<td>Credit Card</td>
							<td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
							<td><span class="badge badge-success">Completed</span></td>
                        </tr>
                        <tr>											
							<td>12-03-2018</td>
							<td>$30</td>
							<td>5%</td>
							<td>Insurance</td>
							<td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
							<td><span class="badge badge-success">Completed</span></td>
                        </tr>
                        <tr>											
							<td>12-03-2018</td>
							<td>$30</td>
							<td>5%</td>
							<td>Credit Card</td>
							<td><button type="button" class="btn btn-outline-info mb-0"><span class="ti-arrow-down"></span> Invoice</button></td>
							<td><span class="badge badge-success">Completed</span></td>
						</tr>									
					</tbody>
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
<script>
	$("#tableId").dataTable();
</script>
@endpush