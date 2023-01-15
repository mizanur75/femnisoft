@extends('layouts.app')

@section('title',$doctor->name.' Profile')

@push('css')
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right">
            @if($doctor->status == 1)
            <button type="button" class="btn btn-success mb-3"><i class="fa fa-check-circle-o"></i> Active</button>
            @else
            <button type="button" class="btn btn-danger mb-3"><i class="fa fa-close"></i> Busy</button>
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
        <div class="widget-area-2 proclinic-box-shadow">
            <div class="row no-mp">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="{{asset('images/doctor/'.$doctor->image)}}" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title">Dr Daniel Smith</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the
                                bulk of the
                                card's
                                content.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td><strong>Specialization</strong></td>
                                    <td>General Physician</td>
                                </tr>
                                <tr>
                                    <td><strong>Experience</strong></td>
                                    <td>14 Years</td>
                                </tr>
                                <tr>
                                    <td><strong>Gender</strong></td>
                                    <td>Male</td>
                                </tr>
                                <tr>
                                    <td><strong>Address</strong></td>
                                    <td>Koramangala
                                        Banglore, India</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone</strong> </td>
                                    <td>+91 11111 11111</td>
                                </tr>
                                <tr>
                                    <td><strong>Date Of Birth</strong> </td>
                                    <td>26-10-1989</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>your@email.com</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
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
                window.location = "{{route('doctor.profile')}}";
            }
        });
    });
});
</script>
@endpush