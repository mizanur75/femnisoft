@extends('layouts.app')

@section('title','Change Password')

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
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
                <!-- <a href="#"><button type="button" class="btn btn-padding btn-success"><span class="ti-money"></span> Amount: {{Auth::user()->amount}}</button></a> -->
                @if(\App\Model\Doctor::where('user_id',Auth::user()->id)->count() > 0)
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

    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{Session::get('message')}}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{Session::get('success')}}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    @if(Session::has('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{Session::get('danger')}}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    @if(\App\Model\Doctor::where('user_id',Auth::user()->id)->count() > 0)
        <div class="widget-area-2 proclinic-box-shadow pl-2 pr-2">
                        
            <form action="{{route('doctor.password_changed')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="old_password">Old Password</label>
                        <input type="password" id="old_password" name="old_password" class="form-control form-control-sm">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-sm">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-sm">
                    </div>
                                                        
                    <div class="form-check col-md-6 mb-2">
                        <div class="text-left">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="ex-check-2" required>
                                <label class="custom-control-label" for="ex-check-2">Please Confirm</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-refresh"></i> Update</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    </div>
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