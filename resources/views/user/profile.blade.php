@extends('layouts.app')

@section('title',$doctor->name.' Profile')

@push('css')
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="row float-right">
                        <div class="col-md-6 col-sm-3">
                        @if(\App\Model\Doctor::where('user_id',Auth::user()->id)->count() > 0)
                        <select name="status" class="form-control form-control-sm {{$doctor->status == 0 ? 'bg-danger':'bg-success'}}" style="color:white; height: 2.4rem;" id="status">
                            <option selected="false" disabled>Change Status</option>
                            <option value="0" {{$doctor->status == 0 ? 'selected':''}}>Busy</option>
                            <option value="1" {{$doctor->status == 1 ? 'selected':''}}>Active</option>
                        </select>
                        </div>
                        <div class="col-md-6 col-sm-3">
                        
                            <a href="{{route('doctor.profile.edit',Auth::user()->id)}}"><button type="button" class="btn btn-success mb-3"><span class="ti-pencil-alt"></span> Edit Profile</button></a>
                        @else
                            <a href="{{route('doctor.profile.create')}}"><button type="button" class="btn btn-success mb-3"><span class="ti-pencil-alt"></span> Create Profile</button></a>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
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
        <div class="widget-area-2 proclinic-box-shadow">
            <div class="row no-mp">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="{{asset('images/doctor/'.$doctor->image)}}" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title">{{$doctor->name}}</h4>
                            <p class="card-text text-center">{{$doctor->title}}</p>
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
                                <tr>
                                    <td><strong>Experience</strong></td>
                                    <td>{{$doctor->experience}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone</strong> </td>
                                    <td>{{$doctor->phone}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{$doctor->email}}</td>
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
            <h3 class="widget-title">Doctor Activity</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Injury/Condition</th>
                            <th>Visit Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Manoj Kumar</td>
                            <td>Viral fever</td>
                            <td>12-03-2018</td>
                            <td>Condition is good</td>
                        </tr>
                        <tr>
                            <td>Riya </td>
                            <td>Hand Fracture</td>
                            <td>12-10-2018</td>
                            <td>Small Operation</td>
                        </tr>
                        <tr>
                            <td>Paul</td>
                            <td>Dengue</td>
                            <td>15-10-2018</td>
                            <td>Admintted in Generalward</td>
                        </tr>
                        <tr>
                            <td>Manoj Kumar</td>
                            <td>Malayria</td>
                            <td>12-03-2018</td>
                            <td>Condition is good</td>
                        </tr>
                        <tr>
                            <td>Manoj Kumar</td>
                            <td>Viral fever</td>
                            <td>12-03-2018</td>
                            <td>Condition is good</td>
                        </tr>
                        <tr>
                            <td>Riya </td>
                            <td>Hand Fracture</td>
                            <td>12-10-2018</td>
                            <td>Small Operation</td>
                        </tr>
                        <tr>
                            <td>Paul</td>
                            <td>Dengue</td>
                            <td>15-10-2018</td>
                            <td>Admintted in Generalward</td>
                        </tr>
                        <tr>
                            <td>Manoj Kumar</td>
                            <td>Malayria</td>
                            <td>12-03-2018</td>
                            <td>Condition is good</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
</div>
@endsection

@push('scripts')
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
@endpush