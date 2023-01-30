@extends('layouts.app')
@section('title','Edit Advice')

@push('css')
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/select2-bootstrap4.min.css')}}">

@endpush


@section('content')
<style>
.phide{
	display: none;
}
.pshow{
	display: block;
}
.thide{
	display: none;
}
.tshow{
	display: block;
}
form .row>[class^=col] {
    padding-top: .0rem !important;
    padding-bottom: .0rem !important;
    background-color: #fff !important;
    border: 0px !important;
}
.widget-area-2 {
    background: #fff;
    margin-top: .6rem;
    padding: 0px 10px 0px 0px;
    padding-bottom: 2px;
    border-radius: 2px;
}
.form-control {
    border-color: #064619;
}
select.form-control:not([size]):not([multiple]) {
    height: 2.16rem;

}

input.form-control{
	height: 2.16rem;
	width: 70px;
}
div.form-control{
	height: 2.16rem;
}
p {
    font-size: 1em;
    line-height: 1.2em;
    color: #666;
    letter-spacing: .3px;
    margin-top: 0;
    margin-bottom: 0.8rem;
}
.error{
	color: red;
	font-weight: bold;
}
.select2-results__option {
    padding: 2px 8px;
    user-select: none;
    -webkit-user-select: none;
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
.multiselect {
  width: 100%;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
	display: block;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}
.form-control {
    padding: .3rem .3rem;
}
</style>

    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{Session::get('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif

    @if($errors->any())
		@foreach($errors->all() as $error)
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Opps!</strong> {{$error}}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endforeach
	@endif


<form action="{{route('doctor.prescription.update',$appoint->history_id)}}" method="POST" id="presform" multiple="true">
	@csrf
	@method('PUT')
	<input type="hidden" value="{{$appoint->pare_id}}" name="request_id">
	<input type="hidden" value="{{$appoint->history_id}}" name="history_id">
	<input type="hidden" value="{{$appoint->id}}" name="patient_id">
	<input type="hidden" value="{{$appoint->did}}" name="doctor_id">
	<div class="row" style="margin: 14px 0px;">
		<div class="col-md-12">
			<div class="widget-area-2 text-right mb-2">
				<a href="{{route('doctor.prescription.show',$appoint->history_id)}}" class="btn btn-padding btn-sm btn-danger"><i class="fa fa-cancel"></i>	Cancel</a>
				<button type="submit" class="btn btn-padding btn-sm btn-success"><i class="fa fa-sync"></i>	Update</button>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 bg-white mt-2" id="pres" style="padding: 13px 12px;">
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
						$birth_date = new \DateTime($info->age);
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
				<div class="col-sm-2 pt-0 pb-0 patient" style="border-right:1px solid #2b6749 !important;"><b>Gender:</b> {{$info->gender == 0?'Male':'Female'}}</div>
				<div class="col-sm-2 pt-0 pb-0 patient" style="border-right:1px solid #2b6749 !important;"><b>Addr:</b> {{$info->address}}</div>
				<div class="col-sm-2 pt-0 pb-0"><b>Date:</b> {{date('d M Y', strtotime(now()))}}</div>
			</div>
			<div class="row" style="border-top: 1px solid #2b6749;">
				<div class="col-sm-4 col-md-4" style="border-right: 1px solid #2b6749 !important;">
					<div class="row mb-2">
						<div class="col-sm-12 col-md-12">
							<b for="">Patient History:</b>
							<hr>
							<textarea style="min-height: 400px;" class="form-control col-md-12 col-sm-12" id="nic-edit" name="cc" placeholder="History">{{$appoint->cc}}</textarea>
						</div>
					</div>
				</div>

				<div class="col-sm-8 col-md-8" style="min-height:400px;font-size:1em;padding-top:5px;border-left:1px solid #2b6749;">
					<div class="row mt-4 mb-4">
						<div class="col-sm-12 col-md-12">
							<textarea id="advice_text" class="form-control" name="advice_text">{!!$info->advice_text!!}</textarea>
						</div>
						<div class="col-sm-12 col-md-12 mt-4">
							<h6 class="font-weight-bold">Advice(s):</h6>
							<hr>
							@php($advs = explode(', ',$info->advices))

							<div style="overflow-y: scroll;	max-height: 400px;">
							@foreach($advices as $advice)
								<input id="{{$advice->id}}" @if(in_array($advice->id,$advs)) checked @endif type="checkbox" name="advice[]" value="{{$advice->id}}">
								<label for="{{$advice->id}}">{{$advice->name}}</label><br>

							@endforeach
							</div>
						</div>
						<div class="col-sm-6 col-md-6 mt-3">
							<h6><b>Electronic Signature</b></h6>
							<hr>
							<img src="{{asset('images/signature/'.$appoint->signature)}}" style="height: 70px;">
							<h5 class="font-weight-bold" style="margin-bottom: 0px;">{{$appoint->dname}}</h5>
							<span>{{$appoint->education}}</span><br>
							<span>{{$appoint->specialist}}</span><br>
                            @if($appoint->regi_no)
							<span>Gov. Aff. No: {{$appoint->regi_no}}</span>
                                @endif
						</div>
					</div>
					<div class="row mt-2 mb-2">
                        <div class="col-md-3 col-sm-3">
                            <textarea class="form-control col-md-12 col-sm-12" name="comment" placeholder="Comments">{{$info->comment}}</textarea>
                        </div>
						<div class="col-md-3 col-sm-3">
							<textarea class="form-control col-md-12 col-sm-12" name="referred" placeholder="Referred to">{{$info->referred}}</textarea>
						</div>
					</div>
				</div>

			</div>
			<div class="row text-center" style="border-top:1px solid #2b6749; padding:5px; text-align: center !important;">
				<div class="col-sm-12 col-print text-center">
	                    <select name="next_meet">
                            <option selected="false"  disabled>Select</option>
                            @for($i = 0; $i <= 21; $i++)
                            <option value="{{$i}}" {{substr($info->next_meet,0, -4) == $i ? 'selected' : ''}}>{{$i}}</option>
                            @endfor
                        </select>
					<input type="radio" id="day" name="meet_day" value="day" {{substr($info->next_meet, -3) == 'day' ? 'checked' : ''}}> <label for="day">দিন</label>
					<input type="radio" id="week" name="meet_day" value="wek" {{substr($info->next_meet, -3) == 'wek' ? 'checked' : ''}}> <label for="week">সপ্তাহ</label>
					<input type="radio" id="month" name="meet_day" value="mon" {{substr($info->next_meet, -3) == 'mon' ? 'checked' : ''}}> <label for="month">মাস</label>
					   Bring the document with you on your next visit. Thank You.
				</div>
			</div>

			<div class="row" style="border-top:1px solid #2b6749; padding:5px;"></div>
			<div class="col-sm-12 text-center" style="padding: 0px 0px 10px 0px;">
				Prescription Developed & Maintenance by <a href="https://primex-bd.com" target="_blank"> Primex Info Sys Ltd</a>
			</div>
		</div>
	</div>
</form>
@endsection


@push('scripts')
<script src="{{asset('js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/nicEdit.js')}}"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { new nicEditor().panelInstance('nic-edit'); });
</script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { new nicEditor().panelInstance('advice_text'); });
</script>
<script>
	$("#height, #weight").keyup(function(){
		var weight = $("#weight").val();
		var height = $("#height").val();
		var meter = height / 100;
		var bmi = weight / (meter * meter);
		$("#bmi").html(bmi.toFixed(1));
	})
	$(function(){
		$.ajax({
			url: "{{route('doctor.onload_medicine')}}",
			method: "GET",
			data: { _token: "{{csrf_token()}}" },
			success: function(res){
				$.each(res, function(key, value){
					$("#cmbProductInfo").append('<option value="'+value.id+'">'+value.gname+'->'+value.category+'->'+value.medname+'->'+value.mesname+'</option>').html();
				})
			}
		})
	})
</script>
<script>
	var expanded = false;

	function showCheckboxes() {
	  var checkboxes = document.getElementById("checkboxes");
	  if (!expanded) {
	    checkboxes.style.display = "block";
	    expanded = true;
	  } else {
	    checkboxes.style.display = "none";
	    expanded = false;
	  }
	}

	$('.select2').select2({
      theme: 'bootstrap4'
    });
</script>
<!-- show medicine by generic -->
<script type="text/javascript">
	$(".generic").change(function(){
		var catID = $(".category").val();
		var genericID = $(this).val();
		var token = $("input[name='_token']").val();
		$.ajax({
			url: "{{route('doctor.select')}}",
			method: 'POST',
			data: {catID:catID, genericID:genericID, _token:token},
			success: function(data) {
				if(data.length < 1){
					Swal.fire('No Medicine with this category + generic');
				}
				$("#cmbProductInfo").html(data.options);
			}
		});
	});

	$("#cmbProductInfo").change(function(){
		var medicineID = $(this).val();
		if (medicineID == 'medicineNotNeed') {
			medicineNotNeedAddRow();
		}else if(medicineID == 'absentAddRow'){
			absentAddRow();
		}else{
			var token = $("input[name='_token']").val();
			$.ajax({
				url: "{{route('doctor.meddetails')}}",
				method: "POST",
				data: {medID:medicineID, _token:token},
				success:function(res){
					var medicine = res.medicine;
					// console.log($("tbody [value='"+medicine.id+"']").length);
					if ($("tbody [value='"+medicine.id+"']").length < 1){
						addRow(medicine);
					}else {
						Swal.fire("Sorry! You have already added this Medicine!");
					}
				}
			});
		}
	});
	$("#addNewRow").click(function(){
		addRow();
	});
	function addRow(){
	  var addRow = '<tr>'+
	                  '<td>'+
	                      '<div>'+
						  	'<input type="text" class="form-control w-100" name="cmbProductInfo[]" />'+
						  	'<input type="hidden" name="dosage[]" value="1">'+
						  '</div>'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="mes[]" id="mes" class="form-control form-control-sm w-100"></td>'+
	                  '<td>'+
	                      '<select name="cmbDose[]" id="cmbDose" class="form-control form-control-sm" required>'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="সকালে + দুপুরে + রাতে">সকালে + দুপুরে + রাতে</option>'+
	                          '<option value="সকালে + দুপুরে">সকালে + দুপুরে</option>'+
	                          '<option value="সকালে + রাতে">সকালে + রাতে</option>'+
	                          '<option value="দুপু্রে + রাতে">দুপু্রে + রাতে</option>'+
	                          '<option value="সকালে">সকালে</option>'+
	                          '<option value="দুপু্রে">দুপু্রে</option>'+
	                          '<option value="রাতে">রাতে</option>'+
	                          '<option value="৬ ঘণ্টা পর পর">৬ ঘণ্টা পর পর</option>'+
	                          '<option value="১ দিন পরপর">১ দিন পরপর</option>'+
	                          '<option value="প্রতি শুক্রবার - রাতে">প্রতি শুক্রবার - রাতে</option>'+
	                          '<option value="প্রতি শনিবার - রাতে">প্রতি শনিবার - রাতে</option>'+
	                          '<option value="প্রতি রবিবার - রাতে">প্রতি রবিবার - রাতে</option>'+
	                          '<option value="প্রতি সোমবার - রাতে">প্রতি সোমবার - রাতে</option>'+
	                          '<option value="৫০০ মি. লি. পানিতে মিশিয়ে">৫০০ মি. লি. পানিতে মিশিয়ে</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbQty[]" class="form-control form-control-sm" required>'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="১/২">১/২</option>'+
	                          '<option value="৩/৪">৩/৪</option>'+
	                          '<option value="১">১</option>'+
	                          '<option value="১.১/২">১.১/২</option>'+
	                          '<option value="২">২</option>'+
	                          '<option value="২.১/২">২.১/২</option>'+
	                          '<option value="৩">৩</option>'+
	                          '<option value="৪">৪</option>'+
	                          '<option value="১-২">১-২</option>'+
	                          '<option value="৩-৪">৩-৪</option>'+
	                          '<option value="৮-১০">৮-১০</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbQtyType[]" class="form-control form-control-sm" required>'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="চামচ">চামচ</option>'+
	                          '<option value="টি">টি</option>'+
	                          '<option value="চাপ">চাপ</option>'+
	                          '<option value="মি. লি.">মি. লি.</option>'+
	                          '<option value="ফোঁটা">ফোঁটা</option>'+
	                          '<option value="প্যাকেট">প্যাকেট</option>'+
	                          '<option value="বার">বার</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbEat[]" class="form-control form-control-sm" required>'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="খাবার পর">খাবার পর</option>'+
	                          '<option value="খাবার ৩০ মি. আগে">খাবার ৩০ মি. আগে</option>'+
	                          '<option value="খাবার আগে বা পরে">খাবার আগে বা পরে</option>'+
	                          '<option value="খাবার পরে এবং পরবর্তী ২ ঘন্টা কিছু খাবেন না">খাবার পরে এবং পরবর্তী ২ ঘন্টা কিছু খাবেন না</option>'+
	                          '<option value="জ্বর ১০২ ডি. ফা. বা তার বেশি হলে">জ্বর ১০২ ডি. ফা. বা তার বেশি হলে</option>'+
	                          '<option value="বুকে ব্যথা হলে, জিহ্বার নিচে">বুকে ব্যথা হলে, জিহ্বার নিচে</option>'+
	                          '<option value="শ্বাষকষ্ট হলে, ২ নাকের ছিদ্রে">শ্বাষকষ্ট হলে, ২ নাকের ছিদ্রে</option>'+
	                          '<option value="শরীর ব্যথা হলে">শরীর ব্যথা হলে</option>'+
	                          '<option value="আক্রান্ত স্থানে মাখবেন">আক্রান্ত স্থানে মাখবেন</option>'+
	                          '<option value="আক্রান্ত চোখে দিবেন">আক্রান্ত চোখে দিবেন</option>'+
	                          '<option value="আক্রান্ত কানে দিবেন">আক্রান্ত কানে দিবেন</option>'+
	                          '<option value="২ নাকের ছিদ্রে (নাক বন্ধ থাকলে)">২ নাকের ছিদ্রে (নাক বন্ধ থাকলে)</option>'+
	                          '<option value="মুখের ভেতরের ঘাঁতে লাগাবেন">মুখের ভেতরের ঘাঁতে লাগাবেন</option>'+
	                          '<option value="গোসলের ৫ মিনিট আগে">গোসলের ৫ মিনিট আগে</option>'+
	                          '<option value="গোসলের পরে">গোসলের পরে</option>'+
	                          '<option value="পায়খানার রাস্তায়">পায়খানার রাস্তায়</option>'+
	                          '<option value="প্রতিবার পাতলা পায়খানার পর">প্রতিবার পাতলা পায়খানার পর</option>'+
	                          '<option value="পায়খানা পাতলা হলে বন্ধ রাখবেন">পায়খানা পাতলা হলে বন্ধ রাখবেন</option>'+
	                          '<option value="পায়খানার রাস্তায়, প্রতিবার পায়খানার পর ও রাতে ঘুমানোর সময়">পায়খানার রাস্তায়, প্রতিবার পায়খানার পর ও রাতে ঘুমানোর সময়</option>'+
	                          '<option value="খাবারের সাথে খাবেন">খাবারের সাথে খাবেন</option>'+
	                          '<option value="ব্যবহারের পর কুলি করবেন">ব্যবহারের পর কুলি করবেন</option>'+
	                          '<option value="এক গ্লাস পানিতে মিশিয়ে খাবেন">এক গ্লাস পানিতে মিশিয়ে খাবেন</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="eatDuration[]" class="form-control form-control-sm" required>'+
                          '<option selected="false"  disabled>Select</option>'+
                            '<option value="0">0</option>'+
                            '<option value="১">১</option>'+
                            '<option value="২">২</option>'+
                            '<option value="৩">৩</option>'+
                            '<option value="৪">৪</option>'+
                            '<option value="৫">৫</option>'+
                            '<option value="৬">৬</option>'+
                            '<option value="৭">৭</option>'+
                            '<option value="৮">৮</option>'+
                            '<option value="৯">৯</option>'+
                            '<option value="১০">১০</option>'+
                            '<option value="১১">১১</option>'+
                            '<option value="১২">১২</option>'+
                            '<option value="১৩">১৩</option>'+
                            '<option value="১৪">১৪</option>'+
                            '<option value="১৫">১৫</option>'+
                            '<option value="১৬">১৬</option>'+
                            '<option value="১৭">১৭</option>'+
                            '<option value="১৮">১৮</option>'+
                            '<option value="১৯">১৯</option>'+
                            '<option value="২০">২০</option>'+
                            '<option value="২১">২১</option>'+
                        '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbEatDurationType[]" class="form-control form-control-sm" required>'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="দিন">দিন</option>'+
	                          '<option value="সপ্তাহ">সপ্তাহ</option>'+
	                          '<option value="মাস">মাস</option>'+
	                          '<option value="চলবে">চলবে</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
                        '<button type="button" class="btn btn-padding btn-sm btn-danger remove"><i class="fa fa-close"></i> </button>'+
                        '<button type="button" class="btn btn-padding btn-sm btn-outline-primary add_multiple_dosage"><i class="fa fa-plus"></i> </button>'+
                      '</td>'+
	              '</tr>';
	  	$('#tbody').append(addRow);
		$("#cmbDose").focus();
	};


	function medicineNotNeedAddRow(){
	  var medicineNotNeedAddRow = '<tr>'+
	                  '<td>'+
						  	'<input type="text" class="medicine_id form-control form-control-sm" name="cmbProductInfo[]" value="0">'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" class="mes form-control form-control-sm" name="mes[]" id="mes" value="0" readonly>'+
	                      '<input type="hidden" name="dosage[]" value="0"></td>'+
	                  '<td>'+
	                      '<input type="text" name="cmbDose[]" id="cmbDose" class="form-control form-control-sm" value="0" required />'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="cmbQty[]" class="form-control form-control-sm" value="0" required>'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="cmbQtyType[]" class="form-control form-control-sm" value="0" required>'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="cmbEat[]" class="form-control form-control-sm" value="0" required>'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="eatDuration[]" class="form-control form-control-sm" required value="0">'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="cmbEatDurationType[]" class="form-control form-control-sm" value="0" required>'+
	                  '</td>'+
	                  '<td>' +
                        '<button type="button" class="btn btn-padding btn-sm btn-danger remove"><i class="fa fa-close"></i> </button>'+
                      '</td>'+
	              '</tr>';
	  	$('#tbody').append(medicineNotNeedAddRow);
		$("#cmbDose").focus();
	};
	function absentAddRow(){
	  var absentAddRow = '<tr>'+
	                  '<td>'+
						  	'<input type="text" class="medicine_id form-control form-control-sm" name="cmbProductInfo[]" value="00" readonly>'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" class="mes form-control form-control-sm" name="mes[]" id="mes" value="0" readonly>'+
	                      '<input type="hidden" name="dosage[]" value="0"></td>'+
	                  '<td>'+
	                      '<input type="text" name="cmbDose[]" id="cmbDose" class="form-control form-control-sm" value="0" required readonly />'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="cmbQty[]" class="form-control form-control-sm" value="0" required readonly>'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="cmbQtyType[]" class="form-control form-control-sm" value="0" required readonly>'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="cmbEat[]" class="form-control form-control-sm" value="0" required readonly>'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="eatDuration[]" class="form-control form-control-sm" required value="0" readonly>'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" name="cmbEatDurationType[]" class="form-control form-control-sm" value="0" required readonly>'+
	                  '</td>'+
	                  '<td>' +
                        '<button type="button" class="btn btn-padding btn-sm btn-danger remove"><i class="fa fa-close"></i> </button>'+
                      '</td>'+
	              '</tr>';
	  	$('#tbody').append(absentAddRow);
		$("#cmbDose").focus();
	};
	$('table').delegate('.remove','click', function(){
	    $(this).parent().parent().remove();
	});
    $('tbody').delegate('.add_multiple_dosage','click',function(e){
        var tr = $(this).parent().parent();
        var medicine_id = tr.find('.medicine_id').val();
        var mes = tr.find('.mes').val();
        add_multiple_dosage(medicine_id, mes, tr);
    });

</script>
<script>
	$(function(){
		// $('#presform').validate({
		// 	rules: {
		// 		cc: "required",
		// 		withcc: "required",
		// 		diagnosis: "required",
		// 		next_meet: "required"
		// 	},
		// 	messages:{
		// 		cc: "Please write a cc",
		// 		withcc: "Please write a chief complaints",
		// 		diagnosis: "Please write a Diagnosis",
		// 		next_meet: "Please Write Next Meet time"
		// 	}
		// })
        // let diagnosis = '{{$info->diagnosis}}';
        // let sec_diagnosis = '{{$info->sec_diagnosis}}';

        // if (diagnosis == 'HDM' || diagnosis == 'DN' || diagnosis == 'RA' || diagnosis == 'JCA/JRA' || diagnosis == ''){
        //     $("#pri_others").addClass("d-none");
        // }else{
        //     $("#pri_others").removeClass("d-none");
        // }
        // if (sec_diagnosis == 'HDM' || sec_diagnosis == 'DN' || sec_diagnosis == 'RA' || sec_diagnosis == 'JCA/JRA' || sec_diagnosis == ''){
        //     $("#sec_others").addClass("d-none");
        // }else{
        //     $("#sec_others").removeClass("d-none");
        // }

        // // diagnosis
        // $("#diagnosis").change(function(){
        //     if ($("#diagnosis").val() == 'Others'){
        //         $("#pri_others").removeClass("d-none");
        //         $("#pri_others").val('');
        //     }else{
        //         $("#pri_others").addClass("d-none");
        //     }
        // });

        // $("#sec_diagnosis").change(function(){
        //     if ($("#sec_diagnosis").val() == 'Others'){
        //         $("#sec_others").removeClass("d-none");
        //         $("#sec_others").val('');
        //     }else{
        //         $("#sec_others").addClass("d-none");
        //     }
        // });

	});
</script>
@endpush
