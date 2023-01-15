@extends('layouts.app')
@section('title','Invoice Of '.$invoice_master->invoice_no)

@push('css')
<style type="text/css">
	@media (max-width: 768px){
		.text-md-right {
		    text-align: left!important;
		}
		.printarea{
			font-size: .9rem;
		}
	}
</style>
@endpush


@section('content')
<div class="row">
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
        	@if($invoice_master->doctor_id != 0)
        	@if(Auth::user()->id == $invoice_master->doctor->user_id)
            <a href="{{route('doctor.invoice.edit',\Crypt::encrypt($invoice_master->id))}}" class="btn btn-padding btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
            @endif
            @endif
            <button type="button" class="btn btn-padding btn-sm btn-success" id="print"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
	<div class="col-md-12 printarea" id="printarea">
		<div class="widget-area-2 proclinic-box-shadow pb-2">
			<!-- Invoice Head -->
			<div class="row ">
				<div class="col-sm-6 mb-2">
					<h5 class="proclinic-text-color"><img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="height: 60px;"></h5>
					<h3 class="color-green font-weight-bold" style="letter-spacing: 0px; font-size: 16px;">Primex Information System Ltd</h3>
				</div>
				<div class="col-sm-6 text-md-right mb-2 color-black">
					<h3>LAB. INVOICE</h3>
					<span>Date: {{date('d M Y', strtotime($invoice_master->created_at))}}</span><br>
					<span>Invoice No.# {{$invoice_master->invoice_no}}</span><br>
					<span>{{$invoice_master->patient->name}}</span><br>
					<span>PT. ID-{{$invoice_master->patient->centre_patient_id}}</span>
				</div>
			</div>
			<!-- /Invoice Head -->
			<!-- Invoice Content -->
			<div class="row">
				<div class="col-sm-6 mb-1">
					<strong class="proclinic-text-color">Suggested by: 
						@if($invoice_master->doctor_id == 0)
						Self
						@else
						{{$invoice_master->doctor->user->name}}
						@endif
					</strong>
				</div>
				<div class="col-sm-6 mb-1 text-right">
					<strong class="color-black">Patient Type: {{$mem_type == null ? 'OPD' : $mem_type}}
					</strong>
				</div>
				<div class="col-sm-12">
					<table class="table table-bordered table-striped table-invioce color-black">
						<thead>
							<tr class="text-center printarea">
								<th scope="col">#SL</th>
								<th scope="col">Test Name</th>
								<th scope="col">Unit Cost (Tk)</th>
								<th scope="col">Discount (Tk)</th>
								<th scope="col">Line Total (Tk)</th>
							</tr>
						</thead>
						<tbody>
							@php($total = 0)
							@foreach($invoice_master->invoicedetails as $invoice)
							<tr class="text-center">
								<th scope="row">{{$loop->index + 1}}</th>
								<td>{{$invoice->test->test_name}}</td>
								<td>{{$invoice->unitcost}}</td>
								<td>{{$invoice->discount}}</td>
								<td>{{$invoice->linetotal}}</td>
								@php($total += $invoice->linetotal)
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4" class="text-right">
									<strong>TOTAL (Tk)</strong>
								</td>
								<td class="text-center">
									<strong>{{$total}}</strong>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>

				<div class="col-sm-12">
					<div class="border p-2 text-center color-black printarea">
						<!-- <span>এখলাসপুর, মতলব উত্তর, চাঁদপুর ৩৬৪১ | মোবাইল: 01766020707 | ইমেইল: chandpurecoh3641@gmail.com | ওয়েবসাইট: www.ecohbd.org </span>
						<br> -->
						<span style="font-size: .9rem;">Developed By Primex Information System Ltd</span>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>


@endsection


@push('scripts')
<script>
    $("#print").click(function () {
        $("#printarea").show();
        window.print();
    });
</script>
<script>
	function showimage(image){
		var modal = document.getElementById("myModal");
		var modalImg = document.getElementById("img01");
		modal.style.display = "block";
		modalImg.src = image;
	};
	var modal = document.getElementById("myModal");
	var span = document.getElementsByClassName("close")[0];
	span.onclick = function(){
		modal.style.display = "none";
	}
</script>
@endpush
