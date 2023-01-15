@extends('layouts.app')
@section('title','Write Prescription')

@push('css')
{{-- <link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
 <link rel="stylesheet" href="{{asset('css/select2-bootstrap4.min.css')}}"> --}}

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
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
    /* margin-top: 1rem; */
    padding: 0px 10px 0px 0px;
    padding-bottom: 2px;
    border-radius: 2px;
}
.table td, .table th {
    padding: 1px 0px !important;
}
.form-control {
    border-color: #d0d0d0;
}
select.form-control:not([size]):not([multiple]) {
    height: 2.16rem;
}
p {
    font-size: 1em;
    line-height: 0.7em;
    color: #666;
    letter-spacing: .3px;
    margin-top: 0;
    margin-bottom: 0.8rem;
}
</style>
@endpush


@section('content')

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
<form action="{{route('doctor.prescription.store')}}" method="POST" style="">
	@csrf
	<input type="hidden" value="{{$appoint->pare_id}}" name="request_id">
	@if(\App\Model\History::where('request_id',$appoint->pare_id)->where('status',0)->count() > 0)
	<input type="hidden" value="{{$appoint->history_id}}" name="history_id">
	@endif
	<input type="hidden" value="{{$appoint->id}}" name="patient_id">
	<input type="hidden" value="{{$appoint->did}}" name="doctor_id">
	<div class="row" style="margin: 14px 0px;">
		<div class="col-md-12">
			<div class="widget-area-2 text-right pb-2">
			@if(\App\Model\History::where('doctor_id',$appoint->did)->where('patient_id',$appoint->id)->where('status',0)->count() == 0)
				<input type="radio" id="hide0" value="0" name="prescribe"> <label for="hide0" class="font-weight-bold mr-3"> Need Test</label>
				<input type="radio" id="hide1" value="1" name="prescribe" checked> <label for="hide1" class="font-weight-bold mr-3"> Direct Prescription</label>
				@else
				<input type="radio" id="hide2" value="2" name="prescribe" checked> <label for="hide2" class="font-weight-bold mr-3"> Suggested Prescription</label>
			@endif
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check-circle"></i>	Ok</button>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 bg-white mt-3" id="pres" style="padding: 13px 24px;">
			<div class="row" style="padding: 20px 0px 10px 0px;">
				<div class="col-md-4 col-sm-3">
					<h4>{{$appoint->dname}}</h4>
					<div class="">{{$appoint->education}}</div>
					<div class="">{{$appoint->specialist}}</div>
					<div class=""><strong style="color: green;">{{$appoint->work}}</strong></div>
				</div>
				<div class="col-md-4 tcol-sm-3 text-center float-right">
				<h4>Chamber</h4>
					<div class="">Doctor Degree</div>
					<div class="">Doctor Training</div>
					<div class=""><strong style="color: green;">Imagine Hospital</strong></div>
				</div>
				<div class="col-md-4 col-sm-3 text-right">
					<h4>{{$appoint->dname}}</h4>
					<div class="">{{$appoint->education}}</div>
					<div class="">{{$appoint->specialist}}</div>
					<div class=""><strong style="color: green;">{{$appoint->work}}</strong></div>
				</div>
			</div>

			<div class="row" style="padding:5px 0px 5px 0px;border-top:1px solid #2b6749;border-bottom:1px solid #2b6749 !important;">
				<div class="col-sm-5 pt-0 pb-0" style="border-right:1px solid #2b6749 !important;">Name : {{$appoint->name}}</div>
				<div class="col-sm-2 pt-0 pb-0"  style="border-right:1px solid #2b6749 !important;;">Age : {{$appoint->age}}</div>
				<div class="col-sm-2 pt-0 pb-0" style="border-right:1px solid #2b6749 !important;;">Sex : {{$appoint->gender == 0?'Male':'Female'}}</div>
				<div class="col-sm-2 pt-0 pb-0"> Date : {{date('d M Y', strtotime(now()))}}</div>
			</div>
			<div class="row">
				<div class="col-sm-2" style="border-right: 1px solid #2b6749 !important;">
						<br>
					<p>BP <b style="margin-left: 20px;">:</b> {{$appoint->blood_presure}}</p>
					<p>BS<b style="margin-left: 20px;">:</b> {{$appoint->blood_sugar}}</p>
					<p>Pulse<b style="margin-left: 20px;">:</b>{{$appoint->pulse}}</p>
					<br>
					<div class="row mb-2">
						<div class="col-sm-12 col-md-12">
							<textarea class="form-control col-md-12 col-sm-12" name="symptom" placeholder="Symptom"></textarea>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-sm-12 col-md-12">
							<textarea class="form-control col-md-12 col-sm-12" name="test" placeholder="Test Name"></textarea>
						</div>
					</div>
				</div>

				<div class="col-sm-10" style="min-height:400px;font-size:1em;padding-top:5px;border-left:1px solid #2b6749;">
					<div class="table-responsive">
						<table class="table table-sm">
							<thead>
								<tr>
									<th>Category</th>
									<th>Generic</th>
									<th>Medicine</th>
									<th>Doses</th>
									<th>Qty</th>
									<th>Qty Type</th>
									<th>Eat Time</th>
									<th>Duration</th>
									<th>Dur. Type</th>
									<th>
										<button type="button" class="btn btn-sm btn-success addRow" name="dis"><i class="fa fa-plus"></i> </button>
									</th>
								</tr>
							</thead>
							<tbody>
							<tr>
								<td>
									<select id="category" class="form-control form-control-sm select2">
										<option selected="false"  disabled>Category</option>
										@foreach($types as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
										@endforeach
									</select>
								</td>
								<td>
									<!-- <select id="generic" class="form-control form-control-sm selectpicker show-tick" data-live-search="true"> -->
									<select id="generic" class="form-control form-control-sm select2" data-live-search="true">
										<option selected="false"  disabled>Generic</option>
										@foreach($generics as $generic)
										<option value="{{$generic->id}}">{{$generic->name}}</option>
										@endforeach
									</select>
								</td>
								<td>
									<select name="cmbMedicine[]" id="med" class="form-control form-control-sm duplicat select2">
										<option selected="false"  disabled>Medicine</option>
									</select>
								</td>
								<td>
									<select name="cmbDose[]" class="form-control form-control-sm">
										<option selected="false"  disabled>Select</option>
										<option value="1+1+1">1+1+1</option>
										<option value="1+1+0">1+1+0</option>
										<option value="1+0+0">1+0+0</option>
										<option value="0+1+1">0+1+1</option>
										<option value="0+0+1">0+0+1</option>
										<option value="0+1+0">0+1+0</option>
										<option value="1+0+1">1+0+1</option>
										<option value="1+1+1+1">1+1+1+1</option>
									</select>
								</td>
								<td>
									<select name="cmbQty[]" class="form-control form-control-sm">
										<option selected="false"  disabled>Select</option>
										<?php
										$i=1;
										for($i=1; $i<5; $i++){
											
											echo "<option value='$i'>".$i."</option>";
										}
										?>
									</select>
								</td>
								<td>
									<select name="cmbQtyType[]" class="form-control form-control-sm">
										<option selected="false"  disabled>Select</option>
										<option value="চামচ">চামচ</option>
										<option value="টি">টি</option>
									</select>
								</td>
								<td>
									<select name="cmbEat[]" class="form-control form-control-sm">
										<option selected="false"  disabled>Select</option>
										<option value="খাবার পর">খাবার পর</option>
										<option value="খাবার আগে">খাবার আগে</option>
									</select>
								</td>
								<td>
									<select name="eatDuration[]" class="form-control form-control-sm">
									<?php
										$i=1;
										echo "<option selected='false' disabled> Select </option>";
										for($i=1; $i<22; $i++){
										
										echo "<option value='$i'>".$i."</option>";
										}
									?>
									</select>
								</td>
								<td>
									<select name="cmbEatDurationType[]" class="form-control form-control-sm">
									<option selected="false"  disabled>Select</option>
										<option value="দিন">দিন</option>
										<option value="মাস">মাস</option>
									</select>
								</td>
								<td><button type="button" class="btn btn-sm btn-danger remove" name="dis"><i class="fa fa-close"></i> </button></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row" style="border-top:1px solid #2b6749;padding:5px;">
			
			</div>
			<div class="col-sm-12 text-center" style="padding: 0px 0px 10px 0px;">
				This is computer generated Prescription. Generated by <a href="http://devmizanur.com" target="_blank"> Mizanur Rahman</a>
			</div>
		</div>
		<div class="col-md-12 bg-white mt-3 thide" id="test" style="padding: 13px 24px;">
			<div class="row" style="padding: 7px;" id="test">
				<div class="col-sm-12 col-md-12">
					<textarea class="form-control col-md-12 col-sm-12" name="onlytest" placeholder="Test Name"></textarea>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection


@push('scripts')
{{-- <script src="{{asset('js/select2.full.min.js')}}"></script> --}}
{{-- <script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
$(function(){
	$('.select2').select2({
      theme: 'bootstrap4'
    });
    $('#select3').select2({
      theme: 'bootstrap4'
    });
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
});
</script>
<!-- show medicine by generic -->
<script type="text/javascript">
  $("#generic").change(function(){
      var catID = $("#category").val();
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
				$("#med").empty();
				$.each(data, function(key, value){
					$("#med").append('<option value="'+value.id+'"> '+ value.name +' </option>');
				});
          }
      });
  });
</script>
<!-- Show medicine by generic when add new row-->
<script type="text/javascript">
	$('tbody').delegate('#generic','change', function(){
		var tr = $(this).parent().parent();
		var catID = tr.find('#category').val();
		var genericID = tr.find('#generic').val();
	    var token = $("input[name='_token']").val();
	    $.ajax({
	        url: "{{route('doctor.select')}}",
	        method: 'POST',
	        data: {catID:catID, genericID:genericID , _token:token},
	        success: function(data) {
				if(data.length < 1){
					Swal.fire('No Medicine with this category + generic');
				}
				$("#medName").empty();
				$.each(data, function(key, value){
					$("#medName").append('<option value="'+value.id+'">'+ value.name +' </option>');
				});
	        }
	    });
	});

// Add new Row and function

	$('.addRow').click(function() {
	  addRow();
	});
	function addRow(){
	  var addRow = '<tr>'+
	                  '<td>'+
	                      '<select name="cmbProductCategory" id="category" class="form-control form-control-sm select3">'+
	                          	'<option selected="false" disabled>Category</option>'+
	                          	'@foreach($types as $type)'+
								'<option value="{{$type->id}}">{{$type->name}}</option>'+
								'@endforeach'+
	                      '</select>'+
					  '</td>'+
					  '<td>'+
	                      '<select name="cmbProductCategory" id="generic" class="form-control form-control-sm select3">'+
								'<option selected="false" disabled>Generic</option>'+
								'@foreach($generics as $generic)'+
								'<option value="{{$generic->id}}">{{$generic->name}}</option>'+
								'@endforeach'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbProductInfo[]" id="medName" class="form-control duplicat select3">'+
	                          	'<option selected="false" disabled>Medicine</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbDose[]" class="form-control form-control-sm">'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="1+1+1">1+1+1</option>'+
	                          '<option value="1+1+0">1+1+0</option>'+
	                          '<option value="1+0+0">1+0+0</option>'+
	                          '<option value="0+1+1">0+1+1</option>'+
	                          '<option value="0+0+1">0+0+1</option>'+
	                          '<option value="0+1+0">0+1+0</option>'+
	                          '<option value="1+0+1">1+0+1</option>'+
	                          '<option value="1+1+1+1">1+1+1+1</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbQty[]" class="form-control form-control-sm">'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="1">1</option>'+
	                          '<option value="2">2</option>'+
	                          '<option value="3">3</option>'+
	                          '<option value="4">4</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbQtyType[]" class="form-control form-control-sm">'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="চামচ">চামচ</option>'+
	                          '<option value="টি">টি</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="cmbEat[]" class="form-control form-control-sm">'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="খাবার পর">খাবার পর</option>'+
	                          '<option value="খাবার আগে">খাবার আগে</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td>'+
	                      '<select name="eatDuration[]" class="form-control form-control-sm">'+
                          '<option selected="false"  disabled>Select</option>'+
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
	                      '<select name="cmbEatDurationType[]" class="form-control form-control-sm">'+
	                          '<option selected="false" disabled>Select</option>'+
	                          '<option value="দিন">দিন</option>'+
	                          '<option value="মাস">মাস</option>'+
	                      '</select>'+
	                  '</td>'+
	                  '<td><button type="button" class="btn btn-sm btn-danger remove" name="dis"><i class="fa fa-close"></i> </button></td>'+
	              '</tr>';
	  $('tbody').prepend(addRow);
	};
	$('table').delegate('.remove','click', function(){
	  var l = $('tbody tr').length;
	  if (l==1) {
	    Swal.fire('You can not remove last one');
	  }else{
	    $(this).parent().parent().remove();
	  }
	});
</script>
@endpush