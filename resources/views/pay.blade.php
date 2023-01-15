@extends('layouts.app')

@section('title',' Pay Now')

@push('css')
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
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{Session::get('danger')}}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->

    <div class="col-md-12">

        <div class="widget-area-2 proclinic-box-shadow">
            <div class="row">
                <div class="col-md-8 mt-3">
                    <a href="javascript:void(0)" title="SSLCommerz" alt="SSLCommerz"><img style="width:100%; height:auto;" src="{{asset('ssl.png')}}" /></a>
                </div>
                <div class="col-md-4 order-md-1">
                    <form method="POST" action="{{url('/pay')}}" class="needs-validation" novalidate>
                        @csrf
                        <button class="btn btn-primary btn-lg btn-block" id="sslczPayBtn"
                                token="{{csrf_token()}}"
                                postdata="your javascript arrays or objects which requires in backend"
                                order="If you already have the transaction generated for current order"
                                endpoint="{{ url('/pay') }}"> Pay Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
</div>
@endsection

@push('scripts')
<script>
$(function(){
});
</script>
@endpush