@extends('layouts.app')

@section('title','Pharma Dashboard')

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
        <div class="widget-area proclinic-box-shadow color-red">
            <div class="widget-left">
                <i class="fas fa-capsules radius"></i>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Total Medicines</h4>
                <span class="numeric color-red">{{$medicines->count()}}</span>
                <p class="inc-dec mb-0"><span class="ti-angle-up"></span> +20% Increased</p>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
    <div class="col-md-3">
        <div class="widget-area proclinic-box-shadow color-green">
            <div class="widget-left">
                <i class="fas fa-capsules radius"></i>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">My Medicines</h4>
                <span class="numeric color-green">{{$medicines->where('user_id', Auth::user()->id)->count()}}</span>
                <p class="inc-dec mb-0"><span class="ti-angle-down"></span> -15% Decreased</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="widget-area proclinic-box-shadow color-yellow">
            <div class="widget-left">
                <i class="fa fa-tag radius"></i>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Total Category</h4>
                <span class="numeric color-yellow">{{$categories->count()}}</span>
                <p class="inc-dec mb-0"><span class="ti-angle-down"></span> -15% Decreased</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="widget-area proclinic-box-shadow color-blue">
            <div class="widget-left">
                <i class="fa fa-list radius"></i>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Total Generics</h4>
                <span class="numeric color-blue">{{$generics->count()}}</span>
                <p class="inc-dec mb-0"><span class="ti-angle-down"></span> -15% Decreased</p>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <!-- Widget Item -->
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Most Prescribed Medicine (100)</h3>
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped" id="prescribed_medicine">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Pharmaceuticals</th>
                            <th>Category</th>
                            <th>Generic</th>
                            <th>Measurement</th>
                            <th class="text-center">Medicine Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mostprescribed as $most)
                        <tr>
                            <td>{{$loop->index +1}}</td>
                            <td>{{$most->pharma}}</td>
                            <td>{{$most->cat}}</td>
                            <td>{{$most->gen}}</td>
                            <td>{{$most->mes}}</td>
                            <td class="text-center">{{$most->medname}}</td>
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
    $(function(){
        // alert();
    })
    $("#prescribed_medicine").dataTable();
</script>
@endpush