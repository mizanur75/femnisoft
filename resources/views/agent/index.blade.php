@extends('layouts.app')

@section('title','Easy Doctor')

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
    <div class="col-md-4">
        <div class="widget-area proclinic-box-shadow color-red">
            <div class="widget-left">
                <span class="ti-wheelchair"></span>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Total Patients</h4>
                <span class="numeric color-red">{{$patients->count()}}</span>
                <p class="inc-dec mb-0"><span class="ti-angle-up"></span> +20% Increased</p>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
    <div class="col-md-4">
        <div class="widget-area proclinic-box-shadow color-green">
            <div class="widget-left">
                <span class="ti-wheelchair"></span>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">My Patients</h4>
                <span class="numeric color-green">{{$patients->where('user_id', Auth::user()->id)->count()}}</span>
                <p class="inc-dec mb-0"><span class="ti-angle-down"></span> -15% Decreased</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="widget-area proclinic-box-shadow color-blue">
            <div class="widget-left">
                <i class="fa fa-user-md" style="border-radius: 50%;
    border: 1px solid; padding: 17px;"></i>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Total Doctor</h4>
                <span class="numeric color-blue">{{$doctors}}</span>
                <p class="inc-dec mb-0"><span class="ti-angle-down"></span> -15% Decreased</p>
            </div>
        </div>
    </div>
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
            <h3 class="widget-title">Prescriptions Status</h3>
            <div id="pres" class="chart-home"></div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col-md-6">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Appointments Year by Year</h3>
            <div id="lineMorris" class="chart-home"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title"> Patients Year by Year</h3>
            <div id="barMorris" class="chart-home"></div>
        </div>
    </div>
</div> -->

<div class="row">
    <!-- Widget Item -->
    <div class="col-md-6">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Appointments</h3>
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped" id="appoint">
                    <thead>
                        <tr class="text-center">
                            <th>#SL</th>
                            <th>D. Name</th>
                            <th>SPC</th>
                            <th>P. Name</th>
                            <th>Address</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appoints as $appoint)
                        <tr>
                            <td>{{$loop->index +1}}</td>
                            <td>{{$appoint->dname}}</td>
                            <td>{{$appoint->spc}}</td>
                            <td>{{$appoint->pname}}</td>
                            <td>{{$appoint->address}}</td>
                            <td>{{date('d M Y', strtotime($appoint->created_at))}}</td>
                            <td class="text-center">
                                @if($appoint->accept == 1 && $appoint->done == 0)
                                <span class="badge badge-info">Accepted</span>
                                @elseif($appoint->accept == 1 && $appoint->done == 1 && $appoint->status == 0)
                                <span class="badge badge-info">Test Suggested</span>
                                @elseif($appoint->accept == 1 && $appoint->done == 1 && $appoint->status == 1)
                                    <span class="badge badge-success">Completed</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->

    <!-- Widget Item -->
    <div class="col-md-6">
        <div class="widget-area-2 progress-status proclinic-box-shadow">
            <h3 class="widget-title">Doctors Availability</h3>
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped" id="available">
                    <thead>
                        <tr class="text-center">
                            <th>#SL</th>
                            <th>Doctor</th>
                            <th>Speciality</th>
                            <th>Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($avldoctors as $doctor)
                        <tr>
                            <td>{{$loop->index +1}}</td>
                            <td>{{$doctor->user->name}}</td>
                            <td>{{$doctor->specialist}}</td>
                            <td class="text-center">
                                @if($doctor->status == 1)
                                <span class="badge badge-success">Available</span>
                                @else
                                <span class="badge badge-danger">Not Available</span>
                                @endif
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
    $("#appoint").dataTable({
        pageLength : 5,
        lengthMenu: [[5, 10], [5, 10]]
    });
    $("#available").dataTable();
if($("#donutMorris").length == 1){
    var $donutData = [
        { label: "Pending", value: "{{$total_appoint->where('done',0)->where('is_delete',0)->count()}}" },
        { label: "Cancelled", value: "{{$total_appoint->where('is_delete',1)->count()}}" },
        { label: "Completed", value: "{{$total_appoint->where('done',1)->count()}}" }
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
if($("#pres").length == 1){
    var $donutData = [
        { label: "Not Ready", value: "{{$pres->where('status',0)->count()}}" },
        { label: "Completed", value: "{{$pres->where('status',1)->count()}}" }
    ];
    Morris.Donut({
        element: 'pres',
        data: $donutData,
        barSize: 0.1,
        labelColor: '#3e5569',
        resize: true, //defaulted to true
        colors: ['#FFAA2A', '#22c6ab']
    });
}
</script>
@endpush