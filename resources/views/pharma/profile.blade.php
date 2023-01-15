@extends('layouts.app')

@section('title',$pharma->name.' Profile')

@push('css')
@endpush

@section('content')
<div class="row">
    @php($count = \App\Model\Pharma::where('user_id',Auth::user()->id)->count())
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
            @if($count > 0)
                <a href="#"><button type="button" class="btn btn-padding btn-success"><span class="ti-money"></span> Amount: {{Auth::user()->amount}}</button></a>
                @if($pharma->is_payment == 1)
                    <a href="#"><button type="button" class="btn btn-padding btn-success"><span class="ti-money"></span> Paid</button></a>
                @elseif($pharma->is_payment == 2)
                    <a href="#"><button type="button" class="btn btn-padding btn-warning"><i class="fas fa-hourglass-end"></i> Expire Soon</button></a>
                    @if( (config('app.last_date') - config('app.current_date') <= 1))
                    <a href="{{ route('gopay') }}" target="_blank"><button type="button" class="btn btn-padding btn-info"><span class="ti-money"></span> Pay Now</button></a>
                    @endif
                @else
                    <a href="#"><button type="button" class="btn btn-padding btn-warning"><span class="ti-money"></span> Payment Not Set</button></a>
                @endif
                <a href="{{route('pharma.profile.edit',Auth::user()->id)}}"><button type="button" class="btn btn-padding btn-success"><span class="ti-pencil-alt"></span> Edit Profile</button></a>
            @else
                <a href="{{route('pharma.profile.create')}}"><button type="button" class="btn btn-padding btn-success"><span class="ti-pencil-alt"></span> Create Profile</button></a>
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
    @if($count > 0)
        <div class="widget-area-2 proclinic-box-shadow">
            <div class="row no-mp">
                <div class="col-md-4">
                    <div class="card mb-4 text-center">
                        <div class="text-center mt-2">
                            <img class="card-img-top" src="{{asset('images/pharma/'.$pharma->logo)}}" alt="{{$pharma->name}}" title="{{$pharma->name}}" style="height: 200px; width: 200px;">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">{{$pharma->name}}</h4>
                            <p class="card-text text-center">{{$pharma->slogan}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td><strong>Phone</strong></td>
                                    <td>{{$pharma->name}}
                                </tr>
                                <tr>
                                    <td><strong>Address</strong></td>
                                    <td>{{$pharma->address}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone</strong> </td>
                                    <td>{{$pharma->phone}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong> </td>
                                    <td>{{$pharma->email}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Open Time</strong></td>
                                    <td>{{$pharma->open_time}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td class="{{$pharma->status == 1 ? 'bg-success':'bg-danger'}}">
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function(){
    $("#status").change(function(){
        var status = $(this).val();
        var token = "{{csrf_token()}}";
        $.ajax({
            url: "",
            method: "POST",
            data: {status: status, _token: token},
            success: function(data){
                window.location = "{{route('pharma.profile.index')}}";
            }
        });
    });
});
</script>
@endpush