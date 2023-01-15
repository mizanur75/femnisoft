@extends('layouts.app')

@section('title','Appoint Payment')

@push('css')
@endpush

@section('content')
<div class="row">
    <!-- Widget Item -->
    <div class="col-md-3">
        <div class="widget-area proclinic-box-shadow color-blue">
            <div class="widget-left">
                <span class="ti-bar-chart"></span>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Total</h4>
                <span class="numeric">{{$total}}</span>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->

    <div class="col-md-3">
        <div class="widget-area proclinic-box-shadow color-yellow">
            <div class="widget-left">
                <span class="ti-user"></span>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Payable</h4>
                <span class="numeric">{{$pay_amount}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <a href="{{route('admin.payment_all')}}">
            <div class="widget-area proclinic-box-shadow color-green">
                <div class="widget-left">
                    <span class="fas fa-store-alt radius"></span>
                </div>
                <div class="widget-right">
                    <h4 class="wiget-title">Paid Amount</h4>
                    @php($paid_total = 0)
                    @foreach($paid_amount as $amount)
                        @php($paid_total += $amount->amount)
                    @endforeach
                    <span class="numeric">{{$paid_total}}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <div class="widget-area proclinic-box-shadow color-green">
            <div class="widget-left">
                <span class="fas fa-store-alt radius"></span>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Due Amount</h4>
                <span class="numeric">{{$pay_amount - $paid_total}}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
