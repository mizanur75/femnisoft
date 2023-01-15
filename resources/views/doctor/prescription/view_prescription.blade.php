@extends('layouts.app')
@section('title','Advice of '.$info->name)

@push('css')
<style>
table tr td{
	border: none !important;
	color: #020202;
}
div[class*="col-"] {
    padding-right: 10px;
    padding-left: 11px;
}
p {
    font-size: 1em;
    line-height: 1.2em;
    color: #020202;
    letter-spacing: .3px;
    margin-top: 0;
    margin-bottom: 0.8rem;
}
hr {
    margin-top: 3px;
    margin-bottom: 3px;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}
.doctor{
	font-size: large;
}

.pf{
	margin-bottom: 3px;
}


@media (min-width: 769px){
	div[class*="col-print"] {
	    padding-right: 5px;
	    padding-left: 5px;
	}
}
@media (max-width: 768px){
	.pl-2{
	    padding-right: 0px;

	}
	.pr-2{
		padding-left: 0px;
	}
}
</style>
@endpush


@section('content')
<div class="row">
	<div class="col-md-12 col-print">
		<div class="widget-area-2 text-right pt-2">
			<!-- <a href="{{route('agent.pdf',$info->hid)}}" target="_blank" class="btn btn-padding btn-sm btn-success"><i class="fa fa-download"></i>	Download</a> -->
			@if(Auth::user()->role->name == 'Doctor' && Auth::user()->id == $info->duser_id)
			<a href="{{route('doctor.edit_prescription',$info->hid)}}" class="btn btn-padding btn-sm btn-success"><i class="fa fa-edit"></i> Edit</a>
			@endif
			<button type="button" id="print" class="btn btn-padding btn-sm btn-info"><i class="fa fa-print"></i> Print</button>
		</div>
	</div>
</div>

<div class="row pres-row">
	<div class="col-sm-12 col-md-12 bg-white mt-3 pres col-pres" id="printarea">
		<div class="row mb-1">
			<div class="col-md-6">
				<h3 style="font-weight: bolder; color: #e99600;">{{$info->dname}}</h3>
				<span>{{$info->education}}</span><br>
				<span>{{$info->regi_no}}</span><br>
				<span>{{$info->spc}}</span><br>
				<span> {{$info->title}}</span><br>
				<span> {{$info->current_work}}</span>
				</table>
			</div>
			<div class="col-md-6 text-right">
				<!-- <h3 style="font-weight: bolder;">ডাঃ আশরাফুল হক সিয়াম</h3>
				<span>এম এস, এমবিবিএস </span><br>
				<span>এ-৪১৭৭৮ </span><br>
				<span>কার্ডিয়াক সার্জন </span><br>
				<span style="color: #e99600;">সহযোগী অধ্যাপক</span><br>
				<span>জাতীয় হৃদরোগ ইনস্টিটিউট ও হাসপাতাল</span> -->
			</div>
		</div>
		<div class="row patient-info">
			<div class="col-sm-2 pt-0 pb-0 patient" style="border-right:1px solid #2b6749 !important;"> 
				<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($info->centerid, 'C39')}}" style="height: 19px;" class="pl-2" alt="barcode" />
			</div>
			<div class="col-sm-3 pt-0 pb-0 patient" style="border-right:1px solid #2b6749 !important;"><b>Name:</b> {{$info->name}}</div>
			<div class="col-sm-1 pt-0 pb-0 patient"  style="border-right:1px solid #2b6749 !important;"><b>Age:</b> 
				<?php
					$birth_date = new \DateTime($info->dob);
			        $meet_date = new \DateTime($info->meet_date);
			        $interval = $birth_date->diff($meet_date);
			        $days = $interval->format('%m M');
			        $age = $interval->format('%y Y');
			    ?>
				@if($age == 0)
			        {{$days}}
			    @else
			        {{$age}} 
				@endif
			</div>
			<div class="col-sm-2 pt-0 pb-0 patient" style="border-right:1px solid #2b6749 !important;"><b>Sex:</b> {{$info->gender == 0?'Male':'Female'}}</div>
			<div class="col-sm-2 pt-0 pb-0 patient" style="border-right:1px solid #2b6749 !important;"><b>Addr:</b> {{$info->address}}</div>
			<div class="col-sm-2 pt-0 pb-0"><b>Date:</b> {{date('d M Y', strtotime($info->meet_date))}}</div>
		</div>
		<div class="row" style="border-top: 1px solid #2b6749; min-height: 700px; padding-left: 5px; padding-right: 5px;">
			<div class="col-sm-4 col-md-4 patient">
				
				<!-- <br>
				<b>On Examination</b>: -->
				<!-- <hr> -->
				
				<div class="row mb-2 mr-2">
					<div class="col-sm-12 col-md-12">
						<strong>Patient History:</strong> <hr> <span class="color-black">{!!$info->cc!!}</span>
					</div>
				</div>
			</div>

			<div class="col-sm-8 col-md-8" style="min-height:400px; font-size:1em; margin-top:20px;">
				<div class="row mt-2 mb-2">
					@if($info->advice_text)
					<div class="col-sm-12 col-md-12 mb-3">
						{!!$info->advice_text!!}
					</div>
					@endif
					<div class="col-sm-12 col-md-12">
						<h6 class="font-weight-bold color-black">Advice(s):</h6>
						<hr>
						@if($info->advices)
							@php($advices = explode(', ',$info->advices))
							<!-- <ul> -->
							@foreach($advices as $advice_id)
							<li class="color-black">
								@php($advice = \App\Model\Advi::where('id',$advice_id)->first())
								{{$advice->name}}
							</li>
							@endforeach
							<!-- </ul> -->
						@endif

					</div>
					<div class="col-sm-6 col-md-6 mt-3">
						<h6 class="color-black"><b>Electronic Signature</b></h6>
						<hr>
						<img src="{{asset('images/signature/'.$info->signature)}}" style="height: 70px; width: 150px;">
						<h5 class="font-weight-bold color-black" style="margin-bottom: 0px;">{{$info->dname}}</h5>
						<span class="color-black">{{$info->education}}</span><br>
						<span class="color-black">{{$info->spc}}</span><br>
						<span class="color-black">BM&DC Reg. No: {{$info->regi_no}}</span>
					</div>
				</div>

				<div class="row mt-3 mb-3 color-black">
                    @if($info->comment)
                        <div class="col-md-4 col-sm-4">
                            <span class="font-weight-bold">Comments:</span>
                            {{$info->comment}}
                        </div>
                    @endif
                <!-- </div>
                <div class="row color-black"> -->
                    @if($info->referred)
                        <div class="col-md-4 col-sm-4">
                            <span class="font-weight-bold">Referred to:</span>
                            {{$info->referred}}
					    </div>
                    @endif
				</div>
				<hr>
				<li class="col-sm-12 col-printd color-black mb-2"style="font-weight: bold;margin-left: -15px !important;">
						@if((substr($info->next_meet, 0, 1) == '0') || $info->next_meet == 0)
						@else
						 Will come <span class="font-weight-bold">
						 	{{$info->next_meet}}
						 </span>  later.
						@endif
						 Bring the document with you on your next visit. Thank You.
					
				</li>
			</div>
		</div>
		<div class="row color-black" style="border-top:1px solid #2b6749;padding:5px; font-size: .9em;">
			<div class="col-sm-12 text-center" style="padding: 0px 0px 10px 0px;">
			    Developed & Maintenance by <a href="https://primex-bd.com" target="_blank"> Primex Information Systems Ltd</a>
			</div>
		</div>
	</div>
</div>
@endsection


@push('scripts')
<script>
$(function(){
	$("#print").click(function(){
		$("#printarea").show();
		window.print();
	});
});
</script>
@endpush
