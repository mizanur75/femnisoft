@extends('layouts.app')
@section('title','Prescription of '.$info->name)

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
			<div class="col-md-5">
				<img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="margin-left: 28px; height: 107px;">
				<h3 class="color-green font-weight-bold" style="letter-spacing: -1px;">এখলাসপুর সেন্টার অফ হেলথ</h3>
			</div>
			<!-- <div class="col-md-2">

			</div> -->
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-5 text-right">
						<img src="{{$info->image == null ? asset('images/patient/default.png') : asset('images/patient/'.$info->image)}}" class="logo" alt="logo" style="margin-top: 7px; width: 25%; border: 1px solid #2b6749;">
						<br>
						<span class="color-black">
							@if($info->visit)
							Visit - {{$info->visit}}
							@else
							@php($visit = \App\Model\History::where('patient_id',$info->patientId)->count())
							Visit - {{$visit}}
							@endif
						</span>
					</div>
					<div class="col-md-7">
						<table>
							<tr>
								<th style="width: 47%;">Name</th>
								<td><b>:</b> {{$info->name}}</td>
							</tr>
							<tr>
								<th>Age</th>
								<td><b>:</b> 
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
								</td>
							</tr>
							<tr>
								<th>Sex</th>
								<td><b>:</b> {{$info->gender == 0?'Male':'Female'}}</td>
							</tr>
							<tr>
								<th>Address</th>
								<td><b>:</b> {{$info->address}}</td>
							</tr>
							<tr>
								<th style="width: 44%;">ECOH ID</th>
								<td><b>:</b> {{$info->centerid}}</td>
							</tr>
							<tr>
								<th>Date</th>
								<td><b>:</b> {{date('d M Y', strtotime($info->meet_date))}}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="border-top: 1px solid #2b6749; min-height: 1170px; padding-left: 5px; padding-right: 5px;">
			<div class="col-sm-4 col-md-4 patient">
				
				<!-- <br>
				<b>On Examination</b>: -->
				<!-- <hr> -->
				<table style="margin-bottom: 10px;">
					<tr>
						<td>Pt. Type</td>
						<td><b>:</b> {{$info->mem_type == null ? ($info->reg_mem == null ? 'OPD' : $info->reg_mem) : $info->mem_type}}</td>
					</tr>
					@if($age >= 18)
					<tr>
						<td>SBP </td>
						<td><b>:</b> {{$info->sbp}} mm of Hg</td>
					</tr>
					<tr>
						<td>DBP </td>
						<td><b>:</b> {{$info->dbp}} mm of Hg</td>
					</tr>
					@endif
					<tr>
						<td style="width: 20%;">O<sub>2</sub> Satu. </td>
						<td><b>:</b> {{$info->oxygen}}%</td>
					</tr>
					<tr>
						<td>Pulse </td>
						<td><b>:</b> {{$info->pulse}}/min</td>
					</tr>
					<tr>
						<td>Temp. </td>
						<td><b>:</b> {{$info->temp}}°F</td>
					</tr>
					<tr>
						<td>Edema </td>
						<td><b>:</b> {{$info->edima == 1 ? 'Present': 'Absent'}}</td>
					</tr>
                    <tr>
                        <td>Anemia </td>
                        <td><b>:</b> {{$info->anemia == 1 ? "Yes" : "No"}}</td>
                    </tr>
                    <tr>
                        <td>Jaundice </td>
                        <td><b>:</b> {{$info->jaundice == 1 ? "Yes" : "No"}}</td>
                    </tr>
					<tr>
						<td>Weight </td>
						<td><b>:</b> {{$info->weight}} kg</td>
					</tr>
					<tr>
						<td>Height </td>
						<td><b>:</b> {{$info->height}} cm</td>
					</tr>
					@if($age >= 15)
					<tr>
						<td>BMI </td>
						<td><b>:</b>
							@php($num = number_format($info->bmi, 1))
							{{$info->bmi}}
							@if($num < 1)
								(N/A)
							@elseif($num > 0 && $num < 18.5)
								(Underweight)
							@elseif($num >= 18.5 && $num <= 24.9)
								(Normal)
							@elseif($num >= 25 && $num <= 29.9)
								(Overweight)
							@elseif($num >= 30 && $num <= 34.9)
								(Obese class 1)
							@elseif($num >= 35 && $num <= 39.9)
								(Obese class 2)
							@else
								(Obese class 3)
							@endif
						</td>
					</tr>
					@endif
					<tr>
						<td>Heart </td>
						<td><b>:</b> {{$info->heart}}</td>
					</tr>
					<tr>
						<td>Lungs </td>
						<td><b>:</b>  {{$info->lungs}}</td>
					</tr>
				</table>
				@if($age >= 18)
				<b>Disease History:</b>
				<hr>
				<table style="margin-bottom: 10px;">
					<tr>
						<td>Diabetes </td>
						<td><b>:</b> {{$info->diabeties == 1 ? "Yes" : "No"}}</td>
					</tr>
					<tr>
						<td>Hypertension </td>
						<td><b>:</b> {{$info->hp == 1 ? "Yes" : "No"}}</td>
					</tr>
				</table>
				@endif
                <b>Behavioural History:</b>
                <hr>
                <table style="margin-bottom: 10px;">
                    <tr>
                        <td>Salt Intake </td>
                        <td><b>:</b> {{$info->salt}}</td>
                    </tr>
                    <tr>
                        <td>Smokeless Tobacco </td>
                        <td><b>:</b> {{$info->smoke}}</td>
                    </tr>
                    <tr>
                        <td>Smoking </td>
                        <td><b>:</b> {{$info->smoking}}</td>
                    </tr>
                </table>
				<b>Previous History:</b>
				<hr>
				<p class="pf">Date: {{$info->predate == null || $info->predate == 'null' ? 'N/A' : date('d-m-Y', strtotime($info->predate))}}</p>
				<p class="pf">Dr/Hosp. Name: {{$info->predochos == null || $info->predochos == 'null' ? 'N/A' : $info->predochos}}</p>
				<p class="pf">Symptom: {{$info->presymptom}}</p>
				<p class="pf">Diagnosis: {{$info->prediagnosis}}</p>
				<p class="pf"><span>Investigation Findings: </span>
					@php($preinvs = \App\Model\Inv::where('patient_info_id',$info->piid)->get())

							@if($preinvs == '[]')
								<li>N/A</li>
							@else
								@foreach($preinvs as $preinv)
									<li class="color-black">{{$preinv->test_name}} - {{$preinv->result == null ? 'N/A' : $preinv->result}}</li>
								@endforeach
							@endif
				</p>
				<p class="pf">Treatment:
					@if($info->pretreatment)
						@php($pretreatment = explode(', ', $info->pretreatment))
						@foreach($pretreatment as $treatment)
							<li class="color-black">{{$treatment == 'null' ? 'N/A': $treatment}}</li>
						@endforeach
					@else
						<li>N/A</li>
					@endif
				</p>
				<div class="row mb-2 mr-2">
					<div class="col-sm-12 col-md-12">
						<strong>Chief Complaints:</strong> <hr> <span class="color-black">{{$info->cc == !null ? $info->cc : 'N/A'}}</span>
					</div>
				</div>

				@php($followinvs = \App\Model\Finv::where('patient_info_id',$info->piid)->get())
					@if(!$followinvs || $followinvs != '[]')
				<b>Follow-up Inv. :</b>
				<hr>
				<p class="pf">
					@foreach($followinvs as $finv)
					<li class="color-black">{{$finv->test_name}} - {{$finv->result}}</li>
					@endforeach
				</p>
				@endif

				<div class="row mb-2 mr-2">
					<div class="col-sm-12 col-md-12">
						<strong>Investigation Find:</strong><hr>
						@if($info->test == !null)
							@php($givenTest = explode(', ',$info->test))
							@foreach($givenTest as $gTest)
								@php($getTest = \App\Model\Test::where('id',$gTest)->first())
								@if($getTest)
    								@php($getResult = \App\Model\Report::where('test_id',$getTest->id)->where('history_id',$info->hid)->first())
    								@if($getResult)
    									<li class="color-black">{{$getTest->test_name}}: {{$getResult->result}} {{$getResult->remark == null ? '':'- '.$getResult->remark}}</li>
    								@else
    									<li class="color-black">{{$gTest}}: </span> <span class="text-danger">Not Added Yet</li>
    								@endif
    							@endif
							@endforeach
						@else
						<span class="color-black">N/A</span>
						@endif
					</div>
				</div>
				<div class="row mb-2 mr-2">
					<div class="col-sm-12 col-md-12">
						<strong>Primary Diagnosis:</strong><hr> <span class="color-black">{{$info->diagnosis == !null ? $info->diagnosis : 'N/A'}}</span>
					</div>
				</div>
                @if($info->sec_diagnosis)
				<div class="row mb-2 mr-2">
					<div class="col-sm-12 col-md-12">
						<strong>Secondary Diagnosis:</strong><hr> <span class="color-black">{{$info->sec_diagnosis}}</span>
					</div>
				</div>
                @endif
				

			</div>

			<div class="col-sm-8 col-md-8" style="min-height:400px; font-size:1em; margin-top:20px;">
				<h3>R<span style="font-size:12px;">x</span></h3>
				<div class="ml-4 table-responsive">
					@if($prescriptions == '[]')
					<span class="color-black">আপনার কোন ঔষধের প্রয়োজন নেই।</span>
					@else
					<table class="table table-sm">
                        @php($index = 0)
						@foreach($prescriptions as $prescription)
                            <tr>
                                @if($prescription->qty == 1)

                                <td style="width: 12%;">
                                    <span class="doctor">
                                        {{$index += 1}}.
                                        @php($cat = substr($prescription->cat, 0, 3))
                                        @if($cat == 'Syr')
                                        Syp.
                                        @else
                                        {{$cat}}.
                                        @endif
                                    </span>
                                </td>
                                <td style="width: fit-content;">
                                    <span class="doctor"> {{$prescription->medname}} - {{$prescription->mes}}</span>
                                </td>
                                @endif
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <li><span class="doctor"> {{$prescription->dose_time}}  ---- </span>
                                    <span class="doctor">
                                    @if($prescription->dose_qty == '১/২')
                                    <sup>১</sup>&frasl;<sub>২</sub>
                                    @elseif($prescription->dose_qty == '৩/৪')
                                    <sup>৩</sup>&frasl;<sub>৪</sub>
                                    @elseif($prescription->dose_qty == '১.১/২')
                                    ১<sup>১</sup>&frasl;<sub>২</sub>
                                    @elseif($prescription->dose_qty == '২.১/২')
                                    ২<sup>১</sup>&frasl;<sub>২</sub>
                                    @else
                                    {{$prescription->dose_qty}}
                                    @endif
                                    {{$prescription->dose_qty_type}} করে {{$prescription->dose_eat}}  ---- </span>

                                        <span class="doctor"> {{$prescription->dose_duration == '0' ? '':$prescription->dose_duration}} {{$prescription->dose_duration_type}}</span></li>
                                </td>
                            </tr>
						@endforeach
					</table>
					@endif
				</div>
				<br>
				<br>
				<br>
				<br>
				<div class="row mt-2 mb-2">
					<div class="col-sm-6 col-md-6">
						<h6 class="font-weight-bold color-black">উপদেশঃ</h6>
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
					<div class="col-sm-6 col-md-6">
						<h6 class="color-black">Electronic Signature</h6>
						<hr>
						<img src="{{asset('images/signature/'.$info->signature)}}" style="height: 70px; width: 150px;">
						<h5 class="font-weight-bold color-black" style="margin-bottom: 0px;">{{$info->dname}}</h5>
						<span class="color-black">{{$info->education}}</span><br>
						<span class="color-black">{{$info->spc}}</span><br>
						<span class="color-black">BM&DC Reg. No: {{$info->regi_no}}</span>
					</div>
				</div>
				@if($info->suggested_test)
				<div class="row mb-2 mr-2">
					<div class="col-sm-12 col-md-12">
						<strong>Follow-up Investigation(s):</strong>
						<hr>
						<span class="color-black">
							@if($info->suggested_test == !null)
								@php($suggested_test = explode(', ', $info->suggested_test))
								@foreach($suggested_test as $stest)
								@php($getTest = \App\Model\Test::where('id',$stest)->first())
								<li>{{$getTest->test_name}}</li>
								@endforeach
							@else
								<li>N/A</li>
							@endif
						</span>
					</div>
				</div>
				@endif

				<div class="row mt-2 color-black">
                    @if($info->follow_up)
                        <div class="col-md-12 col-sm-12">
                            <span class="font-weight-bold">Follow-up:</span>
                            {{$info->follow_up}}
					    </div>
                    @endif
                </div>
                <div class="row color-black">
                    @if($info->comment)
                        <div class="col-md-12 col-sm-12">
                            <span class="font-weight-bold">Comments:</span>
                            {{$info->comment}}
                        </div>
                    @endif
                </div>
                <div class="row color-black">
                    @if($info->referred)
                        <div class="col-md-12 col-sm-12">
                            <span class="font-weight-bold">Referred to:</span>
                            {{$info->referred}}
					    </div>
                    @endif
				</div>
				<div class="col-sm-12 col-print color-black" style="font-weight: bold;margin-left: -12px !important;">
					⚠️ সতর্কতাঃ প্রেসক্রিপশন বুঝতে অসুবিধা হলে বা কোন সন্দেহ থাকলে দয়া করে ইকো'র নিম্নোক্ত মোবাইল নাম্বারে যোগাযোগ করুন। না বুঝে ঔষধ সেবন করবেন না।
				</div>
				<div class="col-sm-12 col-printd color-black"style="font-weight: bold;margin-left: -12px !important;">
					@if((substr($info->next_meet, 0, 1) == '0') || $info->next_meet == 0)
					@else
					 <span class="font-weight-bold">

	                    {{substr($info->next_meet,0, -4) == '0' ? '0' : ''}}
	                    {{substr($info->next_meet,0, -4) == '1' ? '১' : ''}}
	                    {{substr($info->next_meet,0, -4) == '2' ? '২' : ''}}
	                    {{substr($info->next_meet,0, -4) == '3' ? '৩' : ''}}
	                    {{substr($info->next_meet,0, -4) == '4' ? '৪' : ''}}
	                    {{substr($info->next_meet,0, -4) == '5' ? '৫' : ''}}
	                    {{substr($info->next_meet,0, -4) == '6' ? '৬' : ''}}
	                    {{substr($info->next_meet,0, -4) == '7' ? '৭' : ''}}
	                    {{substr($info->next_meet,0, -4) == '8' ? '৮' : ''}}
	                    {{substr($info->next_meet,0, -4) == '9' ? '৯' : ''}}
	                    {{substr($info->next_meet,0, -4) == '10' ? '১০' : ''}}
	                    {{substr($info->next_meet,0, -4) == '11' ? '১১' : ''}}
	                    {{substr($info->next_meet,0, -4) == '12' ? '১২' : ''}}
	                    {{substr($info->next_meet,0, -4) == '13' ? '১৩' : ''}}
	                    {{substr($info->next_meet,0, -4) == '14' ? '১৪' : ''}}
	                    {{substr($info->next_meet,0, -4) == '15' ? '১৫' : ''}}
	                    {{substr($info->next_meet,0, -4) == '16' ? '১৬' : ''}}
	                    {{substr($info->next_meet,0, -4) == '17' ? '১৭' : ''}}
	                    {{substr($info->next_meet,0, -4) == '18' ? '১৮' : ''}}
	                    {{substr($info->next_meet,0, -4) == '19' ? '১৯' : ''}}
	                    {{substr($info->next_meet,0, -4) == '20' ? '২০' : ''}}
	                    {{substr($info->next_meet,0, -4) == '21' ? '২১' : ''}}

					 	@if(substr($info->next_meet, -3) == 'day')
					 	দিন
					 	@elseif(substr($info->next_meet, -3) == 'mon')
					 	মাস
					 	@elseif(substr($info->next_meet, -3) == 'wek')
					 	সপ্তাহ
					 	@endif
					 </span> পর আসবেন।
					@endif
					 পরবর্তী ভিজিটের সময় অবশ্যই ব্যবস্থাপত্র সাথে আনবেন।
				</div>
			</div>
		</div>

		<!-- <div class="row text-center" style="border-top:1px solid #2b6749; padding:5px; text-align: center !important;">
			<div class="col-sm-12 col-print text-center color-black" style="font-weight: bold;">
				⚠️ সতর্কতাঃ ডাক্তারের দেওয়া প্রেসক্রিপশন বুঝতে অসুবিধা হলে বা কোন সন্দেহ থাকলে দয়া করে ইকো'র নিম্নোক্ত মোবাইল নাম্বারে যোগাযোগ করুন। না বুঝে কোন ঔষধ সেবন করবেন না।
			</div>
			<div class="col-sm-12 col-print text-center color-black">
				@if((substr($info->next_meet, 0, 1) == '0') || $info->next_meet == 0)
				@else
				 <span class="font-weight-bold">

                    {{substr($info->next_meet,0, -4) == '0' ? '0' : ''}}
                    {{substr($info->next_meet,0, -4) == '1' ? '১' : ''}}
                    {{substr($info->next_meet,0, -4) == '2' ? '২' : ''}}
                    {{substr($info->next_meet,0, -4) == '3' ? '৩' : ''}}
                    {{substr($info->next_meet,0, -4) == '4' ? '৪' : ''}}
                    {{substr($info->next_meet,0, -4) == '5' ? '৫' : ''}}
                    {{substr($info->next_meet,0, -4) == '6' ? '৬' : ''}}
                    {{substr($info->next_meet,0, -4) == '7' ? '৭' : ''}}
                    {{substr($info->next_meet,0, -4) == '8' ? '৮' : ''}}
                    {{substr($info->next_meet,0, -4) == '9' ? '৯' : ''}}
                    {{substr($info->next_meet,0, -4) == '10' ? '১০' : ''}}
                    {{substr($info->next_meet,0, -4) == '11' ? '১১' : ''}}
                    {{substr($info->next_meet,0, -4) == '12' ? '১২' : ''}}
                    {{substr($info->next_meet,0, -4) == '13' ? '১৩' : ''}}
                    {{substr($info->next_meet,0, -4) == '14' ? '১৪' : ''}}
                    {{substr($info->next_meet,0, -4) == '15' ? '১৫' : ''}}
                    {{substr($info->next_meet,0, -4) == '16' ? '১৬' : ''}}
                    {{substr($info->next_meet,0, -4) == '17' ? '১৭' : ''}}
                    {{substr($info->next_meet,0, -4) == '18' ? '১৮' : ''}}
                    {{substr($info->next_meet,0, -4) == '19' ? '১৯' : ''}}
                    {{substr($info->next_meet,0, -4) == '20' ? '২০' : ''}}
                    {{substr($info->next_meet,0, -4) == '21' ? '২১' : ''}}

				 	@if(substr($info->next_meet, -3) == 'day')
				 	দিন
				 	@elseif(substr($info->next_meet, -3) == 'mon')
				 	মাস
				 	@elseif(substr($info->next_meet, -3) == 'wek')
				 	সপ্তাহ
				 	@endif
				 </span> পর আসবেন।
				@endif
				 পরবর্তী ভিজিটের সময় অবশ্যই ব্যবস্থাপত্র সাথে আনবেন। ধন্যবাদ।
			</div>
		</div> -->
		<div class="row color-black" style="border-top:1px solid #2b6749;padding:5px; font-size: .9em;">
			<div class="col-sm-12 col-print text-center">
				এখলাসপুর, মতলব উত্তর, চাঁদপুর - ৩৬৪১ | মোবাইল: 01766020707 | ইমেইল: chandpurecoh3641@gmail.com | ওয়েবসাইট: www.ecohbd.org <br> Prescription Developed & Maintenance by <a href="https://devmizanur.com" target="_blank"> www.devmizanur.com</a>
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
