@extends('layouts.app')
@section('title','Report of ')

@push('css')

@endpush


@section('content')
<div class="row">
	<div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
            <button type="button" class="btn btn-padding btn-sm btn-success"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow pb-2">
			<!-- Invoice Head -->
			<div class="row ">
				<div class="col-sm-6 mb-2">
					<h5 class="proclinic-text-color"><img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="height: 60px;"></h5>
					<h3 class="color-green font-weight-bold" style="letter-spacing: 0px; font-size: 16px;">Primex Information System Ltd.</h3>
				</div>
				<div class="col-sm-6 text-md-right mb-2">
					<h3>INVOICE</h3>
					<span>Invoice # [123]</span>
					<br>
					<span>Date: December 16, 2017</span>
				</div>
			</div>
			<!-- /Invoice Head -->
			<!-- Invoice Content -->
			<div class="row">
				<div class="col-sm-12 mb-1">
					<strong class="proclinic-text-color">COMMENTS OR SPECIAL INSTRUCTIONS:</strong>
				</div>
				<div class="col-sm-12">
					<table class="table table-bordered table-striped table-invioce">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Description</th>
								<th scope="col">Unit Cost</th>
								<th scope="col">Quantity</th>
								<th scope="col">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>15" Mackbook Pro Retina Display Model 2017</td>
								<td>$ 1999</td>
								<td>1</td>
								<td>$ 1999</td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>21" iMack Retina Display Model 2016</td>
								<td>$ 1399</td>
								<td>1</td>
								<td>$ 1399</td>
							</tr>
							<tr>
								<th scope="row">3</th>
								<td>iPhone X 256 Storage</td>
								<td>$ 1349</td>
								<td>1</td>
								<td>$ 1349</td>
							</tr>

						</tbody>
					</table>
				</div>
				<div class="col-sm-4 ml-auto">
					<table class="table table-bordered table-striped">
						<tbody>
							<tr>
								<td>Subtotal</td>
								<td>$ 4,747</td>
							</tr>
							<tr>
								<td>Tax</td>
								<td>$ 474</td>
							</tr>

							<tr>
								<td>Discount</td>
								<td>$ 20</td>
							</tr>
							<tr>
								<td>
									<strong>GRAND TOTAL</strong>
								</td>
								<td>
									<strong>$ 5,201</strong>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<!-- <div class="col-sm-12">
					<div class="border p-2">
						<span>এখলাসপুর, মতলব উত্তর, চাঁদপুর ৩৬৪১ | মোবাইল: 01766020707 | ইমেইল: chandpurecoh3641@gmail.com | ওয়েবসাইট: www.ecohbd.org </span>
					</div>
				</div> -->

			</div>
		</div>
	</div>
</div>


@endsection


@push('scripts')

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
