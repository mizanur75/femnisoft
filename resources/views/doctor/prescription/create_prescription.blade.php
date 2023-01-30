@extends('layouts.app')
@section('title','Write Advice')

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


<form action="{{route('doctor.prescription.store')}}" method="POST" id="presform" multiple="true">
	@csrf
	<input type="hidden" value="{{$appoint->pare_id}}" name="request_id">
	<input type="hidden" value="{{$appoint->id}}" name="patient_id">
	<input type="hidden" value="{{$appoint->did}}" name="doctor_id">
	<div class="row" style="margin: 14px 0px;">
		<div class="col-md-12 col-sm-12 bg-white mt-2" id="pres" style="padding: 13px 12px;">
			<div class="row mb-1">
				<div class="col-md-6">
					<h3 style="font-weight: bolder; color: #e99600;">{{$appoint->dname}}</h3>
					<span>{{$appoint->education}}</span><br>
					<span>{{$appoint->regi_no}}</span><br>
					<span>{{$appoint->specialist}}</span><br>
					<span> {{$appoint->title}}</span><br>
					<span> {{$appoint->current_work}}</span>
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
					<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($appoint->centre_patient_id, 'C39')}}" style="height: 19px;" class="pl-2" alt="barcode" />
				</div>
				<div class="col-sm-3 pt-0 pb-0 patient" style="border-right:1px solid #2b6749 !important;"><b>Name:</b> {{$appoint->name}}</div>
				<div class="col-sm-1 pt-0 pb-0 patient"  style="border-right:1px solid #2b6749 !important;"><b>Age:</b> 
					<?php
						$birth_date = new \DateTime($appoint->age);
				        $meet_date = new \DateTime(date('d M Y', strtotime(now())));
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
				<div class="col-sm-2 pt-0 pb-0 patient" style="border-right:1px solid #2b6749 !important;"><b>Sex:</b> {{$appoint->gender == 0?'Male':'Female'}}</div>
				<div class="col-sm-2 pt-0 pb-0 patient" style="border-right:1px solid #2b6749 !important;"><b>Addr:</b> {{$appoint->address}}</div>
				<div class="col-sm-2 pt-0 pb-0"><b>Date:</b> {{date('d M Y', strtotime(now()))}}</div>
			</div>
			<div class="row" style="border-top: 1px solid #2b6749;">
				<div class="col-sm-4 col-md-4" style="border-right: 1px solid #2b6749 !important;">
					
					<!-- <br>
					<b>O/E:</b> -->
					<!-- <hr> -->

					<div class="row mb-2">
						<div class="col-sm-12 col-md-12">
							<b class="mt-2">Patient History:</b>
							<textarea style="min-height: 500px;" id="nic-edit" class="form-control col-md-12 col-sm-12 pr_cc" name="cc"></textarea>
						</div>
					</div>
				</div>

				<div class="col-sm-8 col-md-8" style="min-height:500px;font-size:1em; padding-top:5px; border-left:1px solid #2b6749;">
					<div class="table-responsive">

                        <div class="col-md-12 col-sm-12 mt-3">
                            <textarea class="form-control col-md-12 col-sm-12" id="advice_text" name="advice_text"></textarea>
                        </div>
						<h6 class="font-weight-bold mt-2">Advice(s):</h6>
							<hr>
						<div style="overflow-y: scroll;	max-height: 300px;">
							@foreach($advices as $advice)
								<input id="{{$advice->id}}" type="checkbox" name="advice[]" value="{{$advice->id}}">
								<label for="{{$advice->id}}">{{$advice->name}}</label><br>
							@endforeach
						</div>

					</div>

					<div class="row mt-2 mb-2">
						<div class="col-sm-6 col-md-6">
							<h6><b>Electronic Signature</b></h6>
							<hr>
							<img src="{{asset('images/signature/'.$appoint->signature)}}" style="height: 70px;">
							<h5 class="font-weight-bold" style="margin-bottom: 0px;">{{$appoint->dname}}</h5>
							<span>{{$appoint->education}}</span><br>
							<span>{{$appoint->specialist}}</span><br>
							<span>BM&DC Reg. No: {{$appoint->regi_no}}</span>
						</div>
					</div>
					<div class="row mt-2 mb-2">
                        <div class="col-md-6 col-sm-6">
                            <textarea class="form-control col-md-12 col-sm-12" name="comment" placeholder="Comments"></textarea>
                        </div>
						<div class="col-md-6 col-sm-6">
							<textarea class="form-control col-md-12 col-sm-12" name="referred" placeholder="Referred to"></textarea>
						</div>
					</div>
				</div>

			</div>
			<div class="row text-center" style="border-top:1px solid #2b6749; padding:5px; text-align: center !important;">
				<div class="col-sm-12 col-print text-center">
	                    <select name="next_meet">
                            <option selected="false"  disabled>Select</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                        </select>
					<input type="radio" id="day" name="meet_day" value="day"> <label for="day">Day</label>
					<input type="radio" id="week" name="meet_day" value="week"> <label for="week">Week</label>
					<input type="radio" id="month" name="meet_day" value="month"> <label for="month">Month</label>
					  Will come later. Bring the document with you on your next visit. Thank You.
					  <button type="submit" class="btn btn-padding btn-sm btn-success"><i class="fa fa-check-circle"></i> Create </button>
				</div>
			</div>

			<div class="row" style="border-top:1px solid #2b6749; padding:5px;"></div>
			<div class="col-sm-12 text-center" style="padding: 0px 0px 10px 0px;">
				Developed & Maintenance by <a href="https://primex-bd.com" target="_blank"> Primex Information Systems Ltd</a>
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
    $(".pretreatment_med").click(function(){
        var pre_treatment_id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{route('doctor.pre_meddetails')}}",
            method: "POST",
            data: {pre_treatment_id:pre_treatment_id, _token:token},
            success:function(res){
                var medicine = res.medicine;
                var dosage = res.dosage;
                if ($("tbody [value='"+medicine.id+"']").length < 1){
                    PreaddRow(medicine, dosage);
                }else {
                    Swal.fire("Sorry! You have already added. Please remove first then add again!");
                }
            }
        });
    });
    function PreaddRow(medicine, dosage){
        var PreaddRow = '<tr>'+
            '<td>'+
            '<div class="form-control">'+
            '<input type="hidden" class="medicine_id" name="cmbProductInfo[]" value="'+medicine.id+'">'+
            medicine.medname +
            '</div>'+
            '</td>'+
            '<td>'+
            '<div class="form-control">'+
            '<input type="hidden" class="mes" name="mes[]" id="mes" value="'+medicine.mesname+'" class="form-control form-control-sm" readonly>'+medicine.mesname+'<input type="hidden" name="dosage[]" value="1"></td>'+
            '</div>'+
            '<td>'+
            '<select name="cmbDose[]" id="cmbDose" class="form-control form-control-sm" required>'+
            '<option selected="false" disabled>Select</option>'+
            '<option value="'+dosage.dose_time+'" selected>'+(dosage.dose_time == null ? "" : dosage.dose_time)+'</option>'+
            '@foreach($frequecies as $frequecy)'+
            '<option value="{{$frequecy->name}}">{{$frequecy->name}}</option>'+
            '@endforeach'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<select name="cmbQty[]" class="form-control form-control-sm" required>'+
            '<option selected="false" disabled>Select</option>'+
            '<option value="'+dosage.dose_qty+'" selected>'+(dosage.dose_qty == null ? "" : dosage.dose_qty ) +'</option>'+
            '@foreach($qtys as $qty)'+
            '<option value="{{$qty->name}}">{{$qty->name}}</option>'+
            '@endforeach'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<select name="cmbQtyType[]" class="form-control form-control-sm" required>'+
            '<option selected="false" disabled>Select</option>'+
            '<option value="'+dosage.dose_qty_type+'" selected>'+(dosage.dose_qty_type== null ? "" : dosage.dose_qty_type ) +'</option>'+
            '@foreach($qty_types as $qty_type)'+
            '<option value="{{$qty_type->name}}">{{$qty_type->name}}</option>'+
            '@endforeach'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<select name="cmbEat[]" class="form-control form-control-sm" required>'+
            '<option selected="false" disabled>Select</option>'+
            '<option value="'+dosage.dose_eat+'" selected>'+(dosage.dose_eat == null ? "" : dosage.dose_eat)+'</option>'+
            '@foreach($eating_times as $eat)'+
            '<option value="{{$eat->name}}">{{$eat->name}}</option>'+
            '@endforeach'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<select name="eatDuration[]" class="form-control form-control-sm" required>'+
            '<option selected="false"  disabled>Select</option>'+
            '<option value="'+dosage.dose_duration+'" selected>'+(dosage.dose_duration == null ? "" : dosage.dose_duration)+'</option>'+
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
            '<option value="'+dosage.dose_duration_type+'" selected>'+(dosage.dose_duration_type == null ? "" : dosage.dose_duration_type)+'</option>'+
            '<option value="দিন">দিন</option>'+
            '<option value="সপ্তাহ">সপ্তাহ</option>'+
            '<option value="মাস">মাস</option>'+
            '<option value="চলবে">চলবে</option>'+
            '</select>'+
            '</td>'+
            '<td>' +
            '<button type="button" class="btn btn-padding btn-sm btn-danger remove"><i class="fa fa-close"></i> </button>' +
            '<button type="button" class="btn btn-padding btn-sm btn-outline-primary add_multiple_dosage"><i class="fa fa-plus"></i> </button>' +
            '</td>'+
            '</tr>';
        $('#tbody').append(PreaddRow);
        // $("#cmbDose").focus();

    };
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
<script>
$(function(){
	// default
	$("#pres").addClass('pshow');
	$("#test").addClass('thide');
	//Need Test
	$("#hide0").click(function(){
		$("#pres").removeClass('pshow');
		$("#pres").addClass('phide');
		$("#test").removeClass('thide');
		$("#test").addClass('tshow');
	});

	//Direct Presciption
	$("#hide1").click(function(){
		$("#pres").removeClass('phide');
		$("#pres").addClass('pshow');
		$("#test").removeClass('tshow');
		$("#test").addClass('thide');
	});

	$(".pr_cc").keyup(function(){
		$(".withcc").val($(this).val());
	});
	$(".withcc").keyup(function(){
		$(".pr_cc").val($(this).val());
	});


	$('table').delegate('.border-none','click', function(){
	    var tr = $(this).parent().parent();
	    var med = tr.find('.border-none').val();
	    console.log(med);
	});

	// diagnosis
    // $("#pri_others").addClass("d-none");
    // $("#sec_others").addClass("d-none");
    // $("#diagnosis").change(function(){
    //     if ($("#diagnosis").val() == 'Others'){
    //         $("#pri_others").removeClass("d-none");
    //     }else{
    //         $("#pri_others").addClass("d-none");
    //     }
    // });
    //
    // $("#sec_diagnosis").change(function(){
    //     if ($("#sec_diagnosis").val() == 'Others'){
    //         $("#sec_others").removeClass("d-none");
    //     }else{
    //         $("#sec_others").addClass("d-none");
    //     }
    // });


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
					if ($("#tbody [value='"+medicine.id+"']").length < 1){
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
	                  	'<input type="text" class="medicine_id form-control w-100" name="cmbProductInfo[]"'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" class="mes form-control form-control-sm" name="mes[]" id="mes"><input type="hidden" name="dosage[]" value="1">'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbDose[]" id="cmbDose" class="form-control form-control-sm" required>'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '@foreach($frequecies as $frequecy)'+
	                          '<option value="{{$frequecy->name}}">{{$frequecy->name}}</option>'+
	                          '@endforeach'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbQty[]" class="form-control form-control-sm" required>'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '@foreach($qtys as $qty)'+
	                          '<option value="{{$qty->name}}">{{$qty->name}}</option>'+
	                          '@endforeach'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbQtyType[]" class="form-control form-control-sm" required>'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '@foreach($qty_types as $qty_type)'+
	                          '<option value="{{$qty_type->name}}">{{$qty_type->name}}</option>'+
	                          '@endforeach'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbEat[]" class="form-control form-control-sm" required>'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '@foreach($eating_times as $eat)'+
	                          '<option value="{{$eat->name}}">{{$eat->name}}</option>'+
	                          '@endforeach'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="eatDuration[]" class="form-control form-control-sm" required>'+
                          '<option selected="false"  disabled>Select</option>'+
                            '<option value="0">0</option>'+
                            '<option value="1">1</option>'+
                            '<option value="2">2</option>'+
                            '<option value="3">3</option>'+
                            '<option value="4">4</option>'+
                            '<option value="5">5</option>'+
                            '<option value="6">6</option>'+
                            '<option value="7">7</option>'+
                            '<option value="8">8</option>'+
                            '<option value="9">9</option>'+
                            '<option value="10">10</option>'+
                            '<option value="11">11</option>'+
                            '<option value="12">12</option>'+
                            '<option value="13">13</option>'+
                            '<option value="14">14</option>'+
                            '<option value="15">15</option>'+
                            '<option value="16">16</option>'+
                            '<option value="17">17</option>'+
                            '<option value="18">18</option>'+
                            '<option value="19">19</option>'+
                            '<option value="20">20</option>'+
                            '<option value="21">21</option>'+
                        '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbEatDurationType[]" class="form-control form-control-sm" required>'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="Day">Day</option>'+
	                          '<option value="Week">Week</option>'+
	                          '<option value="Month">Month</option>'+
	                          '<option value="Continue">Continue</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>' +
                        '<button type="button" class="btn btn-padding btn-sm btn-danger remove"><i class="fa fa-close"></i> </button>' +
                        '<button type="button" class="btn btn-padding btn-sm btn-outline-primary add_multiple_dosage"><i class="fa fa-plus"></i> </button>' +
                      '</td>'+
	              '</tr>';
	  	$('#tbody').append(addRow);
		$("#cmbDose").focus();
	};


	$("#NoNeedMedicine").click(function(){
		medicineNotNeedAddRow();
	});

	function medicineNotNeedAddRow(){
	  var medicineNotNeedAddRow = '<tr>'+
	                  '<td>'+
	                  		'<input type="hidden" class="absent form-control form-control-sm" name="absent" value="1">'+
						  	'<input type="text" class="medicine_id form-control form-control-sm w-100" name="cmbProductInfo[]" value="0" readonly>'+
	                  '</td>'+
	                  '<td>'+
	                      '<input type="text" class="mes form-control form-control-sm w-100" name="mes[]" id="mes" value="0" readonly>'+
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
	  	$('#tbody').append(medicineNotNeedAddRow);
		$("#cmbDose").focus();
	};
	function absentAddRow(){
	  var absentAddRow = '<tr>'+
	                  '<td>'+
						  	'<input type="text" class="medicine_id form-control form-control-sm" name="cmbProductInfo[]" value="0" readonly>'+
						  	'<input type="hidden" class="absent form-control form-control-sm" name="absent" value="1" readonly>'+
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

    $('tbody').delegate('.add_multiple_dosage','click',function(){
        var tr = $(this).parent().parent();
        var medicine_id = tr.find('.medicine_id').val();
        var mes = tr.find('.mes').val();
        add_multiple_dosage(medicine_id, mes);
    });

	function add_multiple_dosage(medicine_id, mes){
	    var add_multiple = '<tr>'+
            '<td><input type="hidden" name="cmbProductInfo[]" value="'+ medicine_id +'"></td>'+
            '<td><input type="hidden" name="mes[]" id="mes" value="'+ mes +'"><input type="hidden" name="dosage[]" id="mes" value="0"></td>'+
            '<td>'+
                '<select name="cmbDose[]" id="cmbDose" class="form-control form-control-sm" required>'+
                    '<option selected="false" disabled>Select</option>'+
                    '@foreach($frequecies as $frequecy)'+
                    '<option value="{{$frequecy->name}}">{{$frequecy->name}}</option>'+
                    '@endforeach'+
                '</select>'+
            '</td>'+
            '<td>'+
                '<select name="cmbQty[]" class="form-control form-control-sm" required>'+
                    '<option selected="false" disabled>Select</option>'+
                    '@foreach($qtys as $qty)'+
                    '<option value="{{$qty->name}}">{{$qty->name}}</option>'+
                    '@endforeach'+
                '</select>'+
            '</td>'+
            '<td>'+
                '<select name="cmbQtyType[]" class="form-control form-control-sm" required>'+
                    '<option selected="false" disabled>Select</option>'+
                    '@foreach($qty_types as $qty_type)'+
                    '<option value="{{$qty_type->name}}">{{$qty_type->name}}</option>'+
                    '@endforeach'+
                '</select>'+
            '</td>'+
            '<td>'+
                '<select name="cmbEat[]" class="form-control form-control-sm" required>'+
                    '<option selected="false" disabled>Select</option>'+
                    '@foreach($eating_times as $eat)'+
                    '<option value="{{$eat->name}}">{{$eat->name}}</option>'+
                    '@endforeach'+
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
            '<td>' +
                '<button type="button" class="btn btn-padding btn-sm btn-danger remove"><i class="fa fa-close"></i> </button>' +
            '</td>'+
        '</tr>';
        $('#tbody').append(add_multiple);
    }
</script>
<script>
	$(function(){
		$('#presform').validate({
			rules: {
				cc: "required",
				// heart: "required",
				// lungs: "required",
				// withcc: "required",
				// diagnosis: "required",
				// next_meet: "required"
			},
			messages:{
				cc: "Please write History",
				// heart: "This filed is required",
				// lungs: "This filed is required",
				// withcc: "Please write a chief complaints",
				// diagnosis: "Please write a Diagnosis",
				// next_meet: "Please Write Next Meet time"
			}
		})
	});
</script>
@endpush
