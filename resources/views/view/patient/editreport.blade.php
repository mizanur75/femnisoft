@extends('layouts.app')
@section('title','Edit Report for '.$patient->name)

@push('css')
	<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
	<style>
		@media (max-width: 768px){
			.row{
				margin-left: 0px;
			}
			div[class*="col-"] {
			    padding-left: 0px;
			}
		}
	</style>
@endpush


@section('content')
<div class="row mt-3">
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
</div>
@php

$update_from_doct = route('doctor.update_reports',$history->id);
$update_from_agent = route('agent.history.update',$history->id);

@endphp
<form action="{{Auth::user()->role->name == 'Doctor' ? $update_from_doct : $update_from_agent}}" method="POST" enctype="multipart/form-data" id="preventtosubmit">
			@csrf
			@method('PUT')
<div class="row bg-white mt-3">
	<div class="col-md-12 pt-3">
		<input type="hidden" name="history_id" value="{{$history->id}}">
		<div class="col-md-12 table-responsive">
			<label for="report" class="font-weight-bold"> Select Test Name</label>
			<select name="test_id" class="form-control-sm col-md-8 col-sm-12 float-right mb-2 selectpicker show-tick" id="test_id" data-live-search="true">
				<option selected="false" disabled> Select Test </option>
				@foreach($tests as $test)
				<option value="{{$test->id}}">{{$test->test_name}}</option>
				@endforeach
			</select>
			<table class="table table-sm table-bordered">
				<thead>
					<tr class="font-weight-bold text-center">
						<td>#SL</td>
						<td>Test Name</td>
						<!-- <td>Normal Value</td> -->
						<td>Result</td>
						<td>Remark</td>
						<td>Image</td>
						<td class="text-center">Action</td>
					</tr>
				</thead>
				<tbody id="addRow">
					@if($reports)
					@foreach($reports as $report)
						<tr>
                            <td class="text-center">
                                <input type="hidden" name="test_id[]" class="id" value="{{$report->test->id}}"/>{{$loop->index +1}}</td>
                                <input type="hidden" name="report_id[]" class="report_id" value="{{$report->id}}"/>
                            <td>{{$report->test->test_name}}</td>
                            <!-- <td class="text-center">{{$report->test->default_value}}</td> -->
                            <td>
                                <input type="text" name="result[]" class="form-control form-control-sm" id="result" value="{{$report->result}}" required /></td>
                            <td>
                                <input type="text" name="remark[]" class="form-control form-control-sm" id="remark" value="{{$report->remark}}"/></td>
                            <td>
                                <input type="file" name="image[]" class="form-control form-control-sm" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                @if($report->image)
                                <img src="{{asset('images/report/'.$report->image)}}" style="width: 53px; height: 40px;" id="blah">
                                @else
                                <button type="button" class="btn btn-sm btn-outline-danger">No Image</button>
                                @endif
                            </td>
                            <td class="text-center">
                                <!-- <button type="button" class="btn btn-sm btn-info update" value="update"><i class="fa fa-refresh"></i></button> -->
                                <button type="button" class="btn btn-sm btn-danger delete"><i class="fa fa-close"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr bgcolor="#f9bebe">
                            <td class="text-center" colspan="7"><h3 class="text-danger">Sorry! System could not retrive suggested test.</h3></td>
                        </tr>
                    @endif
				</tbody>
			</table>
		</div>
		@if($reports)
		<button type="button" data-toggle="modal" data-target="#reportForEdit" class="btn btn-sm btn-primary float-right mr-2 mb-2"><i class="fa fa-sync"></i> Update </button>
		@endif
	</div>
</div>

<div class="modal fade" id="reportForEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Input Export Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-wbc" class="col-form-label">WBC</label>
							<input type="text" name="wbc" class="form-control form-control-sm" id="recipient-wbc" value="{{$history->wbc}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-lym" class="col-form-label">%Lym</label>
							<input type="text" name="lym" class="form-control form-control-sm" id="recipient-lym" value="{{$history->lym}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-gra" class="col-form-label">GRA%</label>
							<input type="text" name="gra" class="form-control form-control-sm" id="recipient-gra" value="{{$history->gra}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-rbc" class="col-form-label">RBC</label>
							<input type="text" name="rbc" class="form-control form-control-sm" id="recipient-rbc" value="{{$history->rbc}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="_recipient-hb" class="col-form-label">HGB</label>
							<input type="text" name="hb" class="form-control form-control-sm" id="_recipient-hb" value="{{$history->hb}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-hct" class="col-form-label">HCT</label>
							<input type="text" name="hct" class="form-control form-control-sm" id="recipient-hct" value="{{$history->hct}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-mcv" class="col-form-label">MCV</label>
							<input type="text" name="mcv" class="form-control form-control-sm" id="recipient-mcv" value="{{$history->mcv}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-mch" class="col-form-label">MCH</label>
							<input type="text" name="mch" class="form-control form-control-sm" id="recipient-mch" value="{{$history->mch}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-mchc" class="col-form-label">MCHC</label>
							<input type="text" name="mchc" class="form-control form-control-sm" id="recipient-mchc" value="{{$history->mchc}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-plt" class="col-form-label">PLT</label>
							<input type="text" name="plt" class="form-control form-control-sm" id="recipient-plt" value="{{$history->plt}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="_recipient-esr" class="col-form-label">ESR</label>
							<input type="text" name="esr" class="form-control form-control-sm" id="_recipient-esr" value="{{$history->esr}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-neu" class="col-form-label">%Neu</label>
							<input type="text" name="neu" class="form-control form-control-sm" id="recipient-neu" value="{{$history->neu}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-chol" class="col-form-label">Chol</label>
							<input type="text" name="chol" class="form-control form-control-sm" id="chol" value="{{$history->chol}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-tg" class="col-form-label">TG</label>
							<input type="text" name="tg" class="form-control form-control-sm" id="recipient-tg" value="{{$history->tg}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-glucf" class="col-form-label">Gluc-f</label>
							<input type="text" name="glucf" class="form-control form-control-sm" id="glucf" value="{{$history->glucf}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-glucr" class="col-form-label">Gluc-r</label>
							<input type="text" name="glucr" class="form-control form-control-sm" id="glucr" value="{{$history->glucr}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-gluc2hr" class="col-form-label">Gluc-2hr</label>
							<input type="text" name="gluc2hr" class="form-control form-control-sm" id="gluc2hr" value="{{$history->gluc2hr}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-creat" class="col-form-label">Creat</label>
							<input type="text" name="creat" class="form-control form-control-sm" id="creat" value="{{$history->creat}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-ua" class="col-form-label">UA</label>
							<input type="text" name="ua" class="form-control form-control-sm" id="ua" value="{{$history->ua}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-crp" class="col-form-label">CRP</label>
							<input type="text" name="crp" class="form-control form-control-sm" id="recipient-crp" value="{{$history->crp}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-ra" class="col-form-label">RA</label>
							<input type="text" name="ra" class="form-control form-control-sm" id="ra" value="{{$history->ra}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-ugl" class="col-form-label">U-gl</label>
							<input type="text" name="ugl" class="form-control form-control-sm" id="ugl" value="{{$history->ugl}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-upr" class="col-form-label">U-pr</label>
							<input type="text" name="upr" class="form-control form-control-sm" id="upr" value="{{$history->upr}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-uery" class="col-form-label">U-ery</label>
							<input type="text" name="uery" class="form-control form-control-sm" id="uery" value="{{$history->uery}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-uleu" class="col-form-label">U-leu</label>
							<input type="text" name="uleu" class="form-control form-control-sm" id="uleu" value="{{$history->uleu}}">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-ecg" class="col-form-label">ECG</label>
							<select name="ecg" class="form-control form-control-sm" id="ecg">
								<option selected="false" value="">N/A</option>
								<option value="WNL" {{$history->ecg == 'WNL' ? 'selected' : ''}}>WNL</option>
								<option value="AMI" {{$history->ecg == 'AMI' ? 'selected' : ''}}>AMI</option>
								<option value="IHD" {{$history->ecg == 'IHD' ? 'selected' : ''}}>IHD</option>
								<option value="LVH" {{$history->ecg == 'LVH' ? 'selected' : ''}}>LVH</option>
								<option value="Arrhythmia" {{$history->ecg == 'Arrhythmia' ? 'selected' : ''}}>Arrhythmia</option>
								<option value="Others " {{$history->ecg == 'Others' ? 'selected' : ''}}>Others </option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-usg" class="col-form-label">USG</label>
							<select name="usg" class="form-control form-control-sm" id="usg">
								<option selected="false" value="">N/A</option>
								<option value="Normal" {{$history->usg == 'Normal' ? 'selected' : ''}}>Normal</option>
								<option value="Pregnancy" {{$history->usg == 'Pregnancy' ? 'selected' : ''}}>Pregnancy</option>
								<option value="Abnormal" {{$history->usg == 'Abnormal' ? 'selected' : ''}}>Abnormal</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="recipient-cxr" class="col-form-label">CXR</label>
							<select name="cxr" class="form-control form-control-sm" id="cxr">
								<option selected="false" value="">N/A</option>
								<option value="Normal" {{$history->cxr == 'Normal' ? 'selected' : ''}}>Normal</option>
								<option value="RTI" {{$history->cxr == 'RTI' ? 'selected' : ''}}>RTI</option>
								<option value="Cardiomegaly" {{$history->cxr == 'Cardiomegaly' ? 'selected' : ''}}>Cardiomegaly</option>
								<option value="TB" {{$history->cxr == 'TB' ? 'selected' : ''}}>TB</option>
								<option value="Others " {{$history->cxr == 'Others' ? 'selected' : ''}}>Others </option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
				<button type="submit" id="formSubmit" class="btn btn-padding btn-sm btn-primary"><i class="fas fa-save"></i> OK </button>
			</div>
	    </div>
  	</div>
</div>
</form>
@endsection


@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>
<script>
	$(function(){
	    var role = "{{Auth::user()->role->name}}";
	    let route = '';
	    if(role == 'Doctor'){
            route = "{{route('doctor.selectTest')}}";
        }else{
	        route = "{{route('agent.selectTest')}}";
        }
		$("#test_id").change(function() {
			var id = $(this).val();
			$.ajax({
				url: route,
				method: "POST",
				dataType: "JSON",
				data: {'id':id, _token: "{{csrf_token()}}"},
				success: function(test){

					var newRow = '<tr>'+
                                        '<td class="text-center">'+
                                            '<input type="hidden" name="test_id[]" class="test_id id" value="'+ test.id +'"/>'+ test.id +'</td>'+
                                        '<td>'+ test.test_name +'</td>'+
                                        // '<td class="text-center">'+ test.default_value +'</td>'+
                                        '<td>'+
                                            '<input type="text" name="result[]" class="form-control form-control-sm result" id="result"/></td>'+
                                        '<td>'+
                                            '<input type="text" name="remark[]" class="form-control form-control-sm remark" id="remark"/></td>'+
                                        '<td>'+
                                            '<input type="file" name="image[]" class="form-control form-control-sm image"></td>'+
                                        '<td class="text-center">'+
                                            // '<button type="button" class="btn btn-sm btn-success add" value="add"><i class="fa fa-plus"></i></button>'+
                                            '<button type="button" class="btn btn-sm btn-danger remove"><i class="fa fa-close"></i></button>'+
                                        '</td>'+
                                '</tr>';
					if ($("tbody [value='"+test.id+"']").length < 1){
							$("#addRow").prepend(newRow);
					}else {
						Swal.fire("Sorry! You have already added this Test!");
						$('#result').focus();
					}
					$('#result').focus();
				}
			})
		});
	});
	$('table').delegate('.remove','click', function(){
		$(this).parent().parent().remove();
	});
	$('table').delegate('.delete','click', function(){
		var tr = $(this).parent().parent();
		var report_id = tr.find('.report_id').val();
	    var role = "{{Auth::user()->role->name}}";
	    let route = '';
	    if(role == 'Doctor'){
            route = "{{route('doctor.delete_report')}}";
        }else{
	        route = "{{route('agent.delete_report')}}";
        }
		$.ajax({
			url: route,
			method: "POST",
			dataType: "JSON",
			data: {'report_id': report_id, _token: "{{csrf_token()}}"},
			success: function(res){
				tr.remove();
				Swal.fire(res);
			},
			error: function(e){
				Swal.fire("Opps!");
				console.log(e);
			}
		})
	});
</script>
<script>
	// $("#tableId").dataTable();
	// $(document).on('submit','#preventtosubmit', function(e){
	//    $("#reportForEdit").modal('show');
	//    e.preventDefault();
	//  });
	// $("#formSubmit").on('click',function(){
	// 	form.submit();
	// });
	$(document).keypress(
	  function(event){
	    if (event.which == '13') {
	    	$("#reportForEdit").modal('show');
	      	event.preventDefault();
	    }
	});
</script>

@endpush
