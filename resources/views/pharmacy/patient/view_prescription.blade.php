@extends('layouts.app')
@section('title','Prescription of '.$info->name)

@push('css')
<style>
table tr td{
	border: none !important;
}
</style>
@endpush


@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="widget-area-2 text-right pb-2">
			{{-- <a href="{{route('agent.pdf',$info->hid)}}" class="btn btn-sm btn-success"><i class="fa fa-download"></i>	Download</a> --}}
			{{-- <button type="button" class="btn btn-sm btn-success"><i class="fa fa-shopping-cart"></i>	Order Medicine</button> --}}
			<button type="button" id="print" class="btn btn-sm btn-success"><i class="fa fa-print"></i> Print</button>
		</div>
	</div>
	<div class="col-md-12 bg-white mt-3" id="printarea" style="padding: 13px 24px; margin: 14px 0px;">
		<div class="row" style="padding: 20px 0px 10px 0px;">
			<div class="col-md-4">
				<h4>{{$info->dname}}</h4>
				<div class="">{{$info->education}}</div>
				<div class="">{{$info->spc}}</div>
				<div class=""><strong style="color: green;">{{$info->work}}</strong></div>
			</div>
			<div class="col-md-4 text-center">
			<h4>Chamber</h4>
				<div class="">Doctor Degree</div>
				<div class="">Doctor Training</div>
				<div class=""><strong style="color: green;">Imagine Hospital</strong></div>
			</div>
			<div class="col-md-4 text-right">
				<h4>{{$info->dname}}</h4>
				<div class="">{{$info->education}}</div>
				<div class="">{{$info->spc}}</div>
				<div class=""><strong style="color: green;">{{$info->work}}</strong></div>
			</div>
		</div>

		<div class="row" style="padding:5px 0px 5px 0px;border-top:1px solid #2b6749;border-bottom:1px solid #2b6749 !important;">
			<div class="col-sm-5 pt-0 pb-0" style="border-right:1px solid #2b6749 !important;">Name : {{$info->name}}</div>
			<div class="col-sm-2 pt-0 pb-0"  style="border-right:1px solid #2b6749 !important;;">Age : {{$info->age}}</div>
			<div class="col-sm-2 pt-0 pb-0" style="border-right:1px solid #2b6749 !important;;">Sex : {{$info->gender == 0?'Male':'Female'}}</div>
			<div class="col-sm-2 pt-0 pb-0"> Date : {{date('d M Y', strtotime($info->meet_date))}}</div>
		</div>
		<div class="row">
			<div class="col-sm-3" style="border-right: 1px solid #2b6749 !important;">
				<br>
				<p>BP <b style="margin-left: 20px;">:</b> {{$info->blood_presure}}</p>
				<p>BS<b style="margin-left: 20px;">:</b> {{$info->blood_sugar}}</p>
				<p>Pulse<b style="margin-left: 20px;">:</b>{{$info->pulse}}</p>
				<br>
				<div class="row mb-2 mr-2">
					<div class="col-sm-12 col-md-12">
						Symptom: {{$info->symptom}}
					</div>
				</div>
				<div class="row mb-2 mr-2">
					<div class="col-sm-12 col-md-12">
						Test: {{$info->test == null ? 'No Test Suggested': $info->test}}
					</div>
				</div>
			</div>

			<div class="col-sm-8 ml-3" style="min-height:400px; font-size:1em; margin-top:20px;">
				<h3>R<span style="font-size:12px;">x</span></h3>
				<table class="table table-sm">
					@foreach($prescriptions as $prescription)
					<tr>
						<td></td>
						<td>{{substr($prescription->cat, 0, 3)}}.</td>
						<td>{{$prescription->medname}} - {{$prescription->mes}}</td>
						<td></td>
						<td>{{$prescription->dose_duration}} {{$prescription->dose_duration_type}}</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>{{$prescription->dose_time}}</td>
						<td>{{$prescription->dose_qty}} {{$prescription->dose_qty_type}} ????????? {{$prescription->dose_eat}}</td>
						<td></td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
		<div class="row" style="border-top:1px solid #2b6749;padding:5px;">
		
		</div>
		<div class="col-sm-12 text-center" style="padding: 0px 0px 10px 0px;">
			This is computer generated Prescription. Generated by <a href="http://devmizanur.com" target="_blank"> Mizanur Rahman</a>
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