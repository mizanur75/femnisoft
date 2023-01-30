@extends('layouts.app')

@section('title','Dashboard')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{Session::get('success')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        @if(Session::has('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{Session::get('danger')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
    </div>
                    <!-- Widget Item -->
    <div class="col-md-3">
        <a href="{{route('doctor.patient.index')}}">
            <div class="widget-area proclinic-box-shadow color-red">
                <div class="widget-left">
                    <span class="ti-user"></span>
                </div>
                <div class="widget-right">
                    <h4 class="wiget-title">Total Client</h4>
                    <span class="numeric color-red">{{$patietns->count()}}</span>
                    <p class="inc-dec mb-0"><span class="ti-angle-up"></span> </p>
                </div>
            </div>
        </a>
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
    <div class="col-md-3">
        <a href="{{ route('doctor.appoint.index') }}">
            <div class="widget-area proclinic-box-shadow color-green">
                <div class="widget-left">
                    <span class="ti-bar-chart"></span>
                </div>
                <div class="widget-right">
                    <h4 class="wiget-title">My Appointed</h4>
                    <span class="numeric color-green">{{$myappoint->count()}}</span>
                    <p class="inc-dec mb-0"><span class="ti-angle-up"></span></p>
                </div>
            </div>
        </a>
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
    <div class="col-md-3">
        <a href="{{ route('doctor.prescription.index') }}">
            <div class="widget-area proclinic-box-shadow color-yellow">
                <div class="widget-left">
                    <span class="ti-receipt"></span>
                </div>
                <div class="widget-right">
                    <h4 class="wiget-title">My Advice(s)</h4>
                    <span class="numeric color-yellow">{{$myprescriptions->count()}}</span>
                    <p class="inc-dec mb-0"><span class="ti-angle-up"></span></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('doctor.allprescription') }}">
            <div class="widget-area proclinic-box-shadow color-blue">
                <div class="widget-left">
                    <span class="ti-receipt"></span>
                </div>
                <div class="widget-right">
                    <h4 class="wiget-title">Total Advice(s)</h4>
                    <span class="numeric color-blue">{{$prescriptions->where('status',1)->count()}}</span>
                    <p class="inc-dec mb-0"><span class="ti-angle-up"></span> </p>
                </div>
            </div>
        </a>
    </div>
    <!-- /Widget Item -->
</div>

<div class="row">
    <!-- Widget Item -->
    <div class="col-sm-6">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Appointments Status</h3>
            <div id="donutMorris" class="chart-home"></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Advice(s) Status</h3>
            <div id="prescriptions" class="chart-home"></div>
        </div>
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Request Appointments</h3>
            <div class="table-responsive">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Sys. ID</th>
                            <th>Appoint Date</th>
                            <th>Client ID</th>
							<!-- <th>Dr. Name</th> -->
                            <th>Client Name</th>
							<th>Age</th>
							<th>Address</th>
							<th>Blood Group</th>
							<th>Visit(s)</th>
						</tr>
					</thead>
					<tbody>
                        @php($current_date = date('y-m-d', strtotime(now())))
						@foreach($appoints as $appoint)
						<tr>
							<td class="text-center">{{$loop->index +1}}</td>
							<td class="text-center">{{$appoint->pid}}</td>
                            <td class="text-center">
                                @php($appointDate = date('y-m-d', strtotime($appoint->appoint_date)))
                                @if($appointDate <  $current_date)
                                <blink class="blinking">{{date('d M Y', strtotime($appoint->appoint_date))}}</blink>
                                @else
                                {{date('d M Y', strtotime($appoint->appoint_date))}}
                                @endif
                            </td>
                            <td class="text-center">{{$appoint->centre_patient_id}}</td>
							<!-- <td>{{$appoint->dname}}</td> -->
                            <td>{{$appoint->name}}</td>
							<td class="text-center">
                                @php($dob = strlen($appoint->age) < 5 ? now() : $appoint->age)
                                @php($age = \Carbon\Carbon::parse($dob)->diff(\Carbon\Carbon::now())->format('%y'))
                                {{$age}}
                            </td>
							<td class="text-center">{{$appoint->address}}</td>
							<td class="text-center">{{$appoint->blood_group}}</td>
                            <td class="text-center">
                            <a href="{{route('doctor.appoint.show',$appoint->id)}}">
                                @if(\App\Model\PatientRequest::where('status',1)->where('doctor_id',$appoint->did)->where('patient_id',$appoint->pid)->count() > 0)
                                    <button type="button" class="btn btn-padding btn-sm btn-outline-warning">Old</button>
                                    @else
                                    <button type="button" class="btn btn-padding btn-sm btn-outline-success">New</button>
                                @endif
                            </a>
                            </td>
						</tr>
						@endforeach
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
if($("#donutMorris").length == 1){
    var $donutData = [
        { label: "Pending", value: "{{$myappoint->where('done',0)->where('is_delete',0)->count()}}" },
        { label: "Cancelled", value: "{{$myappoint->where('is_delete',1)->count()}}" },
        { label: "Completed", value: "{{$myappoint->where('done',1)->count()}}" }
    ];
    Morris.Donut({
        element: 'donutMorris',
        data: $donutData,
        barSize: 0.1,
        labelColor: '#3e5569',
        resize: true, //defaulted to true
        colors: ['#FFAA2A', '#ef6e6e', '#22c6ab']
    });
}
if($("#prescriptions").length == 1){
    var $donutData = [
        { label: "Not Ready", value: "{{$prescriptions->where('status',0)->count()}}" },
        { label: "Completed", value: "{{$prescriptions->where('status',1)->count()}}" }
    ];
    Morris.Donut({
        element: 'prescriptions',
        data: $donutData,
        barSize: 0.1,
        labelColor: '#3e5569',
        resize: true, //defaulted to true
        colors: ['#FFAA2A', '#22c6ab']
    });
}
</script>
@endpush
