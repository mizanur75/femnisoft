@extends('layouts.app')

@section('title',$doctor->name.' Profile')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
                <!-- <a href="#"><button type="button" class="btn btn-padding btn-success"><span class="ti-money"></span> Amount: {{Auth::user()->amount}}</button></a> -->
                @if(\App\Model\Doctor::where('user_id',Auth::user()->id)->count() > 0)
                    @if($doctor->is_payment == 1)
                        <!-- <a href="#"><button type="button" class="btn btn-padding btn-success"><span class="ti-money"></span> Paid</button></a> -->
                    @elseif($doctor->is_payment == 2)
                        <!-- <a href="#"><button type="button" class="btn btn-padding btn-warning"><i class="fas fa-hourglass-end"></i>Payment Expire Soon</button></a> -->
                        @if( $last_date - $current_date < 1))
                        <!-- <a href="{{ route('gopay') }}" target="_blank"><button type="button" class="btn btn-padding btn-info"><span class="ti-money"></span> Pay Now</button></a> -->
                        @endif
                    @else
                        <!-- <a href="#"><button type="button" class="btn btn-padding btn-warning"><span class="ti-money"></span> Payment Not Set</button></a> -->
                    @endif
                    <a href="{{route('doctor.password_change')}}"><button type="button" class="btn btn-padding btn-success"> Password Change</button></a>
                    <a href="{{route('doctor.profile.edit',Auth::user()->id)}}"><button type="button" class="btn btn-padding btn-success"><span class="ti-pencil-alt"></span> Edit Profile</button></a>
                    <select name="status" class="btn btn-padding btn-sm {{$doctor->status == 0 ? 'bg-danger':'bg-success'}} col-pr" style="color:white; height: 26px;" id="status">
                        <option selected="false" class="col-pr" disabled>Change Status</option>
                        <option value="0" {{$doctor->status == 0 ? 'selected':''}}>Busy</option>
                        <option value="1" {{$doctor->status == 1 ? 'selected':''}}>Active</option>
                    </select>
                @else
                    <a href="{{route('doctor.profile.create')}}"><button type="button" class="btn btn-padding btn-success"><span class="ti-pencil-alt"></span> Create Profile</button></a>
                @endif
        </div>
    </div>
    
    <div class="col-md-12">
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{Session::get('success')}}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    @if(Session::has('danger'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{Session::get('danger')}}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    @if(\App\Model\Doctor::where('user_id',Auth::user()->id)->count() > 0)
        <div class="widget-area-2 proclinic-box-shadow pl-2 pr-2">
            <div class="row no-mp">
                <div class="col-md-4">
                    <div class="card mb-4 pl-5 pr-5 pt-2">
                        <img class="card-img-top" style="width: 100%; height: 275px;" src="{{asset('images/doctor/'.$doctor->image)}}" alt="Card image">
                        <div class="card-body text-center">
                            <h4 class="card-title">{{$doctor->name}}</h4>
                            <p class="card-text">{{$doctor->title}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td><strong>Specialization</strong></td>
                                    <td>{{$doctor->specialist}}
                                </tr>
                                <!-- <tr>
                                    <td><strong>Current Work</strong></td>
                                    <td>{{$doctor->current_work_station}}</td>
                                </tr> -->
                                <tr>
                                    <td><strong>Work Station</strong></td>
                                    <td>{{$doctor->chamber}}, {{$doctor->chamber_address}}-{{$doctor->chamber_post_code}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Experience</strong></td>
                                    <td>{{$doctor->experience}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Education</strong> </td>
                                    <td>{{$doctor->education}}</td>
                                </tr>
                                <tr>
                                    <td><strong>BM&DC Reg. No.</strong> </td>
                                    <td>{{$doctor->regi_no}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone</strong> </td>
                                    <td>{{$doctor->phone}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{$doctor->email}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Signature</strong></td>
                                    <td><img src="{{asset('images/signature/'.$doctor->signature)}}" style="height: 80px;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Today's Activity</h3>
            <div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							{{-- <th class="no-sort">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" id="select-all">
									<label class="custom-control-label" for="select-all"></label>
								</div>
							</th> --}}
							<th>#SL</th>
							<th>ID</th>
                            <th>PT. ID</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Age</th>
							<th>Address</th>
							<th>Blood Group</th>
							<th>CC</th>
						</tr>
					</thead>
					<tbody>
						@foreach($patients as $patient)
						<tr>
							{{-- <td>
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" id="1">
									<label class="custom-control-label" for="1"></label>
								</div>
							</td> --}}
							<td class="text-center">{{$loop->index +1}}</td>
							<td class="text-center">{{$patient->id}}</td>
                            <td class="text-center">{{$patient->centre_patient_id}}</td>
							<td>{{$patient->name}}</td>
							<td class="text-center">{{$patient->phone}}</td>
							<td class="text-center">
                                @php($age = \Carbon\Carbon::parse($patient->age)->diff(\Carbon\Carbon::now())->format('%y'))
                                {{$age}}
                            </td>
							<td class="text-center">{{$patient->address}}</td>
							<td class="text-center">{{$patient->blood_group}}</td>
							<td class="text-center">
								{{$patient->cc}}
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
@endsection

@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script>
$(function(){
    $("#status").change(function(){
        var status = $(this).val();
        var token = "{{csrf_token()}}";
        $.ajax({
            url: "{{route('doctor.status')}}",
            method: "POST",
            data: {status: status, _token: token},
            success: function(data){
                window.location = "{{route('doctor.profile.index')}}";
            }
        });
    });
});

</script>
<script>
	$("#tableId").dataTable();
</script>
@endpush