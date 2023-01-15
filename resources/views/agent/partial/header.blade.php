<div class="container top-brand">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <div class="sidebar-header"> <a href=""><img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="height: 50px; width: 76%;"></a>
                <!--<h3 style="font-size: 15px; font-weight: bold; color: #e87e31; margin-left: 9px;">Ekhlaspur Center of Health</h3>-->
            </div>
        </div>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link">
                    <!-- <span title="Fullscreen" id="google_translate_element"></span> -->
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle bg-red" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="ti-user" style="background-color: red; color: white;font-weight: bold;"></span>
                </a>
                <div class="dropdown-menu proclinic-box-shadow2 profile animated flipInY">
                    <h5>{{Auth::user()->name}}</h5>
                    <a class="dropdown-item" href="#">
                        <span class="ti-settings"></span> Settings</a>
                    <a class="dropdown-item" href="http://devmizanur.com" target="_blank">
                        <span class="ti-help-alt"></span> Help</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" >
                        <span class="ti-power-off"></span> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                </div>
            </li>
        </ul>

    </nav>
</div>
<!-- /Top Navigation -->
<!-- Menu -->
<div class="container menu-nav">
    <nav class="navbar navbar-expand-lg proclinic-bg text-white">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="ti-menu text-white"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown {{Request::is('agent/dashboard*')?'active':''}}">
                    <a class="nav-link" href="{{route('agent.dashboard')}}">
                    <span class="ti-home"></span> Dashboard</a>
                </li>
                <li class="nav-item dropdown {{Request::is('agent/doctor*')?'active':''}}">
                    <a class="nav-link" href="{{ route('agent.doctor') }}"><i class="fa fa-user-md"></i> Doctors</a>
                </li>
                <li class="nav-item dropdown {{Request::is('agent/patient*')?'active':''}} {{Request::is('agent/history*')?'active':''}} {{Request::is('agent/address*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wheelchair"></i> Patients</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('agent.address.index')}}">Address</a>
                        <a class="dropdown-item" href="{{route('agent.patient.create')}}">Add Patient</a>
                        <a class="dropdown-item" href="{{route('agent.patient.index')}}">All Patients</a>
{{--                        <a class="dropdown-item" href="{{route('agent.mypatient')}}">My Patients</a>--}}
                    </div>
                </li>
                <!-- <li class="nav-item dropdown {{Request::is('agent/pharmacy*')?'active':''}}">
                    <a class="nav-link" href="{{ route('agent.pharmacy') }}"><i class="fas fa-store-alt"></i> Pharmacy</a>
                </li> -->
                <li class="nav-item dropdown {{Request::is('agent/appoint*')?'active':''}}">
                    @php($all_appoint = \App\Model\PatientRequest::where('status',0)->where('is_delete',0)->count())
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-stethoscope"></i>
                        Appointments
                        @if($all_appoint > 0)
                        <span class="badge badge-danger" style="border-radius: 50%;">{{$all_appoint}}</span>
                        @endif

                    </a>
                    <div class="dropdown-menu">
                        @php($today = \Carbon\Carbon::parse()->format('d-m-Y'))
                        @php($today_appoint = \App\Model\PatientRequest::where('status',0)->where('is_delete',0)->where('appoint_date',$today)->count())
                        <a class="dropdown-item" href="{{ route('agent.appoint_today', \Carbon\Carbon::parse()->format('d-m-Y')) }}">Today's Appoint
                            @if($today_appoint > 0)
                            <span class="badge badge-danger" style="border-radius: 50%;">{{$today_appoint}}</span>
                            @endif
                        </a>
                        <a class="dropdown-item" href="{{ route('agent.appointment') }}">
                            All Appoint
                            @if($all_appoint > 0)
                            <span class="badge badge-danger" style="border-radius: 50%;">{{$all_appoint}}</span>
                            @endif
                        </a>
                        <a class="dropdown-item" href="{{ route('display_appoint') }}" target="_blank">
                            Display Appoint
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('agent/prescription*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="ti-receipt"></i> Prescription

                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('agent.todayprescription', \Carbon\Carbon::parse()->format('Y-m-d')) }}">Today's Prescription
                        </a>
                        <a class="dropdown-item" href="{{ route('agent.allprescription') }}">
                            All Prescription
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('agent/test*')?'active':''}}">
                    <a class="nav-link" href="{{route('agent.test.index')}}"><i class="fas fa-vials"></i> Test</a>
                </li>
                <li class="nav-item dropdown {{Request::is('agent/advice*')?'active':''}}">
                    <a class="nav-link" href="{{route('agent.advice.index')}}"><i class="fas fa-puzzle-piece"></i> Advice</a>
                </li>
                <li class="nav-item dropdown {{Request::is('agent/frequency*')?'active':''}} {{Request::is('agent/qtytype*')?'active':''}} {{Request::is('agent/qty*')?'active':''}} {{Request::is('agent/eatingtime*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-tasks"></i> Manage</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{Request::is('agent/frequency*')?'activated':''}}" href="{{route('agent.frequency.index')}}">Frequency</a>
                        <a class="dropdown-item {{Request::is('agent/qty')?'activated':''}}" href="{{route('agent.qty.index')}}">Qty</a>
                        <a class="dropdown-item {{Request::is('agent/qtytype*')?'activated':''}}" href="{{route('agent.qtytype.index')}}">Qty Type</a>
                        <a class="dropdown-item {{Request::is('agent/eatingtime*')?'activated':''}}" href="{{route('agent.eatingtime.index')}}">Eating Time</a>
                    </div>
                </li>
                <!--<li class="nav-item dropdown {{Request::is('agent/invoice*')?'active':''}} {{Request::is('agent/invoice*')?'active':''}}">-->
                <!--    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"-->
                <!--        aria-expanded="false"><i class="fa fa-file-invoice"></i> Invoices</a>-->
                <!--    <div class="dropdown-menu">-->
                <!--        <a class="dropdown-item" href="{{route('agent.invoice.index')}}">Consultation</a>-->
                <!--        <a class="dropdown-item" href="{{route('agent.invoice.create')}}">Labratory</a>-->
                <!--        <a class="dropdown-item" href="{{route('agent.self_invoice')}}">Follow-up</a>-->
                <!--        <a class="dropdown-item" href="{{route('agent.donate.index')}}">Donation</a>-->
                <!--        <a class="dropdown-item"href="{{route('agent.miscellaneous.index')}}" > Balance Forward</a>-->
                <!--        <a class="dropdown-item"href="{{route('agent.cost.index')}}" > Expenditure</a>-->
                <!--        <a class="dropdown-item" href="{{route('agent.report')}}">Report</a>-->
                        <!-- <a class="dropdown-item" href="{{route('agent.payment_all')}}">Payment</a> -->
                <!--    </div>-->
                <!--</li>-->
                {{-- <li class="nav-item dropdown {{Request::is('agent/medicine*')?'active':''}} {{Request::is('agent/type*')?'active':''}} {{Request::is('agent/generic*')?'active':''}} {{Request::is('agent/measurement*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-tasks"></i> Manage</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{Request::is('agent/type*')?'activated':''}}" href="{{route('agent.type.index')}}">Type</a>
                        <a class="dropdown-item {{Request::is('agent/generic*')?'activated':''}}" href="{{route('agent.generic.index')}}">Generic</a>
                        <a class="dropdown-item {{Request::is('agent/measurement*')?'activated':''}}" href="{{route('agent.measurement.index')}}">Measurement</a>
                        <a class="dropdown-item {{Request::is('agent/medicine*')?'activated':''}}" href="{{route('agent.medicine.index')}}">Medicine</a>
                    </div>
                </li> --}}

            </ul>
        </div>
    </nav>
</div>
<!-- /Menu -->
