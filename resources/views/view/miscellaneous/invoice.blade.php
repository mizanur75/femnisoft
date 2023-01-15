@extends('layouts.app')
@section('title','Miscellaneous Invoice')

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
            <button type="button" class="btn btn-padding btn-sm btn-success" id="print"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
	<div class="col-md-12 printarea" id="printarea">
		<div class="widget-area-2 proclinic-box-shadow pb-2">
			<!-- Invoice Head -->
			<div class="row ">
				<div class="col-sm-6 mb-2">
					<h5 class="proclinic-text-color"><img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="height: 60px;"></h5>
					<h3 class="color-green font-weight-bold" style="letter-spacing: 0px; font-size: 16px;">এখলাসপুর সেন্টার অফ হেলথ</h3>
					<!-- <span class="color-black">এখলাসপুর, মতলব উত্তর, চাঁদপুর ৩৬৪১</span> -->
				</div>
				<div class="col-sm-6 text-md-right mb-2 color-black">
					<h3>Miscellaneous Invoice</h3>
					<span>Date: {{date('d M Y', strtotime($invoice->created_at))}}</span><br>
					<span>Invoice No.# ECOH-{{$invoice->id}}</span>
				</div>
			</div>
			<!-- /Invoice Head -->
			<!-- Invoice Content -->
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-bordered table-striped table-invioce color-black">
						<thead>
							<tr class="text-center printarea">
								<th scope="col">Description</th>
								<th scope="col">Date</th>
								<th scope="col">Amount (Tk)</th>
							</tr>
						</thead>
						<tbody>
							<tr class="text-center">
								<td>{{$invoice->name}}</td>
								<td>{{date('d M Y', strtotime($invoice->date))}}</td>
								<td>{{$invoice->amount}}</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="col-sm-12">
					<div class="border p-2 text-center color-black printarea">
						<span>এখলাসপুর, মতলব উত্তর, চাঁদপুর ৩৬৪১ | মোবাইল: 01766020707 | ইমেইল: chandpurecoh3641@gmail.com | ওয়েবসাইট: www.ecohbd.org </span>
						<br>
						<span style="font-size: .9rem;">Developed By devmizanur.com</span>
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
