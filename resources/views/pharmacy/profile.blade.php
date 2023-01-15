@extends('layouts.app')

@section('title',$pharmacy->name.' Profile')

@push('css')
@endpush

@section('content')
<div class="row">
    @php($count = \App\Model\Pharmacy::where('user_id',Auth::user()->id)->count())
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right pt-2">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="row float-right">
                        @if($count > 0)
                        <div class="col-md-3 col-sm-3">
                            <a href="#"><button type="button" class="btn btn-padding btn-success"><span class="ti-money"></span> Amount: {{Auth::user()->amount}}</button></a>
                        </div>
                        <div class="col-md-9 col-sm-9">
                            @if($pharmacy->is_payment == 1)
                                <a href="#"><button type="button" class="btn btn-padding btn-success"><span class="ti-money"></span> Paid</button></a>
                            @elseif($pharmacy->is_payment == 2)
                                <a href="#"><button type="button" class="btn btn-padding btn-warning"><i class="fas fa-hourglass-end"></i> Expire Soon</button></a>
                                @if( (config('app.last_date') - config('app.current_date') <= 1))
                                <a href="{{ route('gopay') }}" target="_blank"><button type="button" class="btn btn-padding btn-info"><span class="ti-money"></span> Pay Now</button></a>
                                @endif
                            @else
                                <a href="#"><button type="button" class="btn btn-padding btn-warning"><span class="ti-money"></span> Payment Not Set</button></a>
                            @endif
                            <a href="{{route('pharmacy.profile.edit',Auth::user()->id)}}"><button type="button" class="btn btn-padding btn-success"><span class="ti-pencil-alt"></span> Edit Profile</button></a>
                        @else
                            <a href="{{route('pharmacy.profile.create')}}"><button type="button" class="btn btn-padding btn-success"><span class="ti-pencil-alt"></span> Create Profile</button></a>
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
    @if($count > 0)
        <div class="widget-area-2 proclinic-box-shadow">
            <div class="row no-mp">
                <div class="col-md-4">
                    <div class="card mb-4 text-center">
                        <div class="text-center mt-2">
                            <img class="card-img-top" src="{{asset('images/pharmacy/'.$pharmacy->logo)}}" alt="{{$pharmacy->name}}" title="{{$pharmacy->name}}" style="height: 200px; width: 200px;">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">{{$pharmacy->name}}</h4>
                            <p class="card-text text-center">{{$pharmacy->slogan}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td><strong>Name</strong></td>
                                    <td>{{$pharmacy->name}}
                                </tr>
                                <tr>
                                    <td><strong>Slogan</strong></td>
                                    <td>{{$pharmacy->slogan}}
                                </tr>
                                <tr>
                                    <td><strong>Phone</strong> </td>
                                    <td>{{$pharmacy->phone}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Address</strong></td>
                                    <td>{{$pharmacy->address}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tax (%)</strong></td>
                                    <td>{{$pharmacy->tax}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Discount (%)</strong></td>
                                    <td>{{$pharmacy->discount}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Open Time</strong></td>
                                    <td>{{$pharmacy->open_time}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td class="{{$pharmacy->status == 1 ? 'bg-success':'bg-danger'}}"></td>
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
            <h3 class="widget-title">Pharmacy Activity</h3>
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
            url: "{{route('pharmacy.status')}}",
            method: "POST",
            data: {status: status, _token: token},
            success: function(data){
                window.location = "{{route('pharmacy.profile.index')}}";
            }
        });
    });
});
</script>
@endpush