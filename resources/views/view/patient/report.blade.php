@extends('layouts.app')
@section('title','Report of '.$info->name)

@push('css')

@endpush


@section('content')
<div class="row" id="printarea">
	<div class="col-md-12 d-none" id="select_printarea_ecoh">
		<div class="widget-area-2 proclinic-box-shadow">
			<table>
				<tr>
					<td width="43%">
						<img src="{{asset('assets/images/logo-dark.png')}}">
					</td>
					<td class="text-right">
						<h2 class="color-green font-weight-bold" style="letter-spacing: 0px; margin-top: 5px; margin-left: 15px; font-size: 52px;">Primex Information System Ltd.
						</h2>
			<!-- <span class="color-green font-weight-bold" style="letter-spacing: 0px; margin-top: 5px; margin-left: 15px; font-size: 28px;">এখলাসপুর, মতলব উত্তর, চাঁদপুর ৩৬৪১</span> -->
					</td>
				</tr>
			</table>
		</div>
	</div>
	<!-- Widget Item -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Patient Info <span class="color-black">PT. ID : {{$info->ecohid}}</span></h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong>Name</strong></td>
							<td>{{$info->name}}</td>
						</tr>
						<tr>
							<td><strong>Age</strong> </td>
							<td>
								{{\Carbon\Carbon::parse($info->age)->diff(\Carbon\Carbon::now())->format('%y')}} Y
							</td>
						</tr>
						<tr>
							<td><strong>Address</strong></td>
							<td>{{$info->address}}</td>
						</tr>
						<tr>
							<td><strong>Date</strong></td>
							<td>
								{{date('d M Y', strtotime($info->created_at))}}
							</td>
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
			 <button type="button" id="print" class="btn btn-sm btn-padding btn-success float-right"><i class="fa fa-print"></i> Print</button>
			<h3 class="widget-title">Suggested by</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong>Doctor Name</strong></td>
							<td>{{$info->dname}}</td>
						</tr>
						<tr>
							<td><strong>Title</strong> </td>
							<td>{{$info->title}}</td>
						</tr>
						<tr>
							<td><strong>Spcialist</strong></td>
							<td>
								{{$info->spcialist}}
							</td>
						</tr>
						<tr>
							<td><strong>Work Station </strong></td>
							<td>{{$info->chamber}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-12 d-none" id="select_printarea">
		<div class="widget-area-2 proclinic-box-shadow">
			<div>
				<div class="table-responsive">
					<table id="tableId" class="table table-bordered table-striped table-sm">
						<thead>
							<tr class="text-center">
								<th width="5%">#SL</th>
								<th width="30%">Test Name</th>
								<!-- <th>Default Value</th> -->
								<th width="40%">Result</th>
								<th width="25%">Remark</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($reports as $report)
								<tr class="text-center">
									<td>{{$loop->index +1}}</td>
									<td>{{$report->test}}</td>
									<!-- <td>{{$report->dvalue}}</td> -->
									<td>{{$report->result}}</td>
									<td>{{$report->remark}}</td>
			          </tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- <div class="col-sm-12 col-print text-center">
			এখলাসপুর, মতলব উত্তর, চাঁদপুর ৩৬৪১ | মোবাইল: 01766020707 | ইমেইল: chandpurecoh3641@gmail.com | ওয়েবসাইট: www.ecohbd.org <br> Developed by <a href="https://devmizanur.com" target="_blank"> www.devmizanur.com</a>
		</div> -->
	</div>
</div>
    <!-- /Widget Item -->
<div class="row">
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
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
			@php($invoice = \App\Model\InvoiceMaster::where('history_id',$info->id)->first())
			@if(Auth::user()->role->name == 'Doctor')
				<a href="{{route('doctor.edit_reports',$info->id)}}" class="float-right btn btn-sm btn-padding btn-info" id="edit"><i class="fa fa-edit"></i>Edit</a>
			@else
				@if($invoice)
					<a href="{{route('agent.invoice.show',\Crypt::encrypt($invoice->id))}}" class="btn btn-padding btn-sm btn-success float-right" id="details"><i class="fa fa-file-invoice"></i>Invoice Details</a>
				@else
					<a href="{{route('agent.invoice_create',\Crypt::encrypt($info->id))}}" class="btn btn-padding btn-sm btn-success float-right" id="create"><i class="fa fa-file-invoice"></i>Create Invoice</a>
				@endif
				<a href="{{route('agent.editreport',\Crypt::encrypt($info->id))}}" class="btn btn-padding btn-sm btn-success float-right mr-1" id="edit"><i class="fa fa-edit"></i> Edit</a>
			@endif
			<h3 class="widget-title">Reports of {{$info->name}} </h3>
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="text-center">
							<th width="5%">#SL</th>
							<th width="25%">Test Name</th>
							<!-- <th>Default Value</th> -->
							<th width="45%">Result</th>
							<th width="15%">Remark</th>
							<th width="10%" id="no_image">Image</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($reports as $report)
							<tr class="text-center">
								<td>{{$loop->index +1}}</td>
								<td>{{$report->test}}</td>
								<!-- <td>{{$report->dvalue}}</td> -->
								<td>{{$report->result}}</td>
								<td>{{$report->remark}}</td>
								<td id="no_image">
									@if($report->image)
									<img onclick="showimage('{{asset('images/report/'.$report->image)}}')" src="{{asset('images/report/'.$report->image)}}" height="100" width="100">
									@else
									<button type="button" class="btn btn-sm btn-outline-danger">No Image</button>
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

<style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 50px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.9);
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 90%;
  max-width: 900px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

@endsection
@push('scripts')
<script>
    $("#print").click(function () {
    	$("#print").addClass('d-none');
    	$("#select_printarea").removeClass('d-none');
    	$("#select_printarea_ecoh").removeClass('d-none');
    	// $("#edit").addClass('d-none');
    	// $("#create").addClass('d-none');
    	// $("#details").addClass('d-none');
      $("#printarea").show();
      window.print();

      $("#print").removeClass('d-none');
      // $("#edit").removeClass('d-none');
      // $("#create").removeClass('d-none');
      // $("#details").removeClass('d-none');
    	$("#select_printarea").addClass('d-none');
    	$("#select_printarea_ecoh").addClass('d-none');
      window.onafterprint = function () {
      	// $("#edit").removeClass('d-none');
	    	// $("#print").removeClass('d-none');
        // $("#create").removeClass('d-none');
        // $("#details").removeClass('d-none');
    		$("#select_printarea").addClass('d-none');
    		$("#select_printarea_ecoh").addClass('d-none');
			}
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
