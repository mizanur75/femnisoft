@extends('layouts.app')
@section('title','Invoice No: O-INV-'.$order->id)

@push('css')
<style>
    @media print {
        body * {
        visibility: hidden;
        }
        #printarea, #printarea * {
        visibility: visible;
        }
        #printarea {
        position: absolute;
        left: 0;
        top: 0;
        }
    }
</style>
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
        <div class="widget-area-2 proclinic-box-shadow pb-3" id="printarea">
        <button class="btn btn-sm" id="print"><i class="fa fa-print"></i></button>
            <!-- Invoice Head -->
            <div class="row">
                <div class="col-sm-6">
                    <h4>{{$order->cname == !null ? $order->cname: 'XXXXXXX'}}</h4>
                    <span class="pr-2">Phone: {{$order->phone}}</span>
                    <br>
                    <span class="pr-2">Address: {{$order->caddress == !null ? $order->caddress: 'XXXXXXX'}}</span>
                </div>
                <div class="col-sm-6 text-md-right">
                    <h3>INVOICE</h3>
                    <span>Invoice # P-INV-{{$order->id}}</span>
                    <br>
                    <span>Invoice Code# {{$order->code}}</span>
                    <br>
                    <span>Date: {{date('d M Y', strtotime($order->created_at))}}</span>
                </div>
            </div>
            <!-- /Invoice Head -->
            <!-- Invoice Content -->
            <div class="row">
                <div class="col-sm-12">
                    <strong class="proclinic-text-color">Order Details:</strong>
                </div>
                <div class="col-sm-12">
                    <table class="table table-sm table-bordered table-striped table-invioce">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Medicine Name</th>
                                <th scope="col">Unit</th>
                                <th class="text-center" scope="col">Unit Cost</th>
                                <th class="text-center" scope="col">Quantity</th>
                                <th class="text-center" scope="col">Discount</th>
                                <th class="text-center" scope="col">Line Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@php($subtotal = 0)
                        	@php($tax = 0)
                        	@foreach($orderdetails as $details)
                        	@php($subtotal += $details->linetotal)
                        	@php($tax = $subtotal * Auth::user()->pharmacy->tax / 100)
                            <tr>
                                <th scope="row">{{$loop->index +1}}</th>
                                <td>{{$details->medname}}</td>
                                <td>{{$details->mesname}}</td>
                                <td class="text-right">{{number_format($details->price, 2, '.','')}}</td>
                                <td class="text-right">{{$details->qty}}</td>
                                <td class="text-right">{{number_format($details->dis, 2, '.','')}}</td>
                                <td class="text-right">{{number_format($details->linetotal, 2, '.','')}}</td>
                            </tr>
							@endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-4 ml-auto">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td>Subtotal</td>
                                <td class="text-right">{{number_format($subtotal, 2, '.', '')}}</td>
                            </tr>
                            <tr>
                                <td>Tax ({{Auth::user()->pharmacy->tax}}%)</td>
                                <td class="text-right">{{number_format($tax, 2, '.', '')}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>GRAND TOTAL</strong>
                                </td>
                                <td class="text-right">
                                    <strong>{{number_format(($subtotal + $tax), 2, '.', '')}}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-sm-12">
                    <div class="border p-2">
                        <strong>Note:</strong> This is Computer Generated Invoice. Generated by  {{Auth::user()->name}}. <strong>Developed and Maintainance By Mizanur Rahman</strong>
                        <br>
                        <strong class="f12">Thanks for your business</strong>
                    </div>
                </div>

            </div>
            <!-- /Invoice Content -->
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    $("#print").click(function(){
        $("#printarea").show();
        window.print();
    });
</script>

@endpush