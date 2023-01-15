<div class="container top-brand">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <div class="sidebar-header"> <a href="">
                <img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="height: 50px;">
            </a>
            <!-- <h3 style="font-size: 15px; font-weight: bold; color: #e87e31; margin-left: 9px;">Ekhlaspur Center of Health</h3> -->
            </div>
        </div>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" style="margin-top: 6px;">
                    <span title="Fullscreen" id="_google_translate_element">
                        {{Auth::user()->name}}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    @php($doctor_image = \App\Model\Doctor::where('user_id',Auth::user()->id)->first())
                    @if($doctor_image)
                        @if(Auth::user()->doctor->image)
                        <img src="{{asset('images/doctor/'.Auth::user()->doctor->image)}}" style="height: 38px; width: 38px; border-radius: 50%;">
                        @else
                        <span class="ti-user" style="background-color: red; color: white;font-weight: bold;"></span>
                        @endif
                    @else
                    <span class="ti-user" style="background-color: red; color: white;font-weight: bold;"></span>
                    @endif
                </a>
                <div class="dropdown-menu proclinic-box-shadow2 profile animated flipInY">
                    <h5>{{Auth::user()->name}}</h5>
                    <a class="dropdown-item" href="{{ route('doctor.profile.index') }}">
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
                <li class="nav-item dropdown {{Request::is('doctor/dashboard*')?'active':''}}">
                    <a class="nav-link" href="{{route('doctor.dashboard')}}">
                    <span class="ti-home"></span> Dashboard</a>
                </li>
                <li class="nav-item dropdown {{Request::is('doctor/profile*')?'active':''}}">
                    <a class="nav-link"href="{{route('doctor.profile.index')}}" ><i class="fa fa-user"></i> Profile</a>
                </li>
                @if(\App\Model\Doctor::where('user_id', Auth::user()->id)->count() > 0)
                <li class="nav-item dropdown {{Request::is('doctor/patient*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wheelchair"></i> Patients</a>
                    <div class="dropdown-menu">
                        <!-- <a class="dropdown-item" href="{{route('doctor.address.index')}}">Address</a> -->
                        <a class="dropdown-item" href="{{route('doctor.patient.create')}}">Add Patient</a>
                        <a class="dropdown-item" href="{{route('doctor.patient.index')}}">All Patients</a>
                        <!-- <a class="dropdown-item" href="{{route('doctor.mypatient')}}">My Patients</a> -->
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('doctor/appoint*')?'active':''}}">
                    @php($all_appoint = \DB::table('patient_requests as pr')->join('doctors as d','d.id','=','pr.doctor_id')->where('d.user_id', Auth::user()->id)->where('pr.status',0)->where('pr.is_delete',0)->count())
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-stethoscope"></i> Appointments
                        @if($all_appoint > 0)
                        <span class="badge badge-success" style="border-radius: 50%;">{{$all_appoint}}</span>
                        @endif

                    </a>
                    <div class="dropdown-menu">
                        @php($today = \Carbon\Carbon::parse()->format('d-m-Y'))
                        @php($today_appoint = \DB::table('patient_requests as pr')->join('doctors as d','d.id','=','pr.doctor_id')->where('d.user_id', Auth::user()->id)->where('pr.status',0)->where('pr.is_delete',0)->where('appoint_date',$today)->count())
                        <a class="dropdown-item" href="{{ route('doctor.all_appoint_today', \Carbon\Carbon::parse()->format('d-m-Y')) }}">
                            Today's Appoint
                        </a>
                        <a class="dropdown-item" href="{{ route('doctor.appoint.index') }}">
                            All Appoint
                            @if($all_appoint > 0)
                            <span class="badge badge-success" style="border-radius: 50%;">{{$all_appoint}}</span>
                            @endif
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('doctor/prescription*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="ti-receipt"></i> Advice

                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('doctor.patient.create')}}">
                            Create Advice
                        </a>
                        <a class="dropdown-item" href="{{ route('doctor.todayPrescrition', \Carbon\Carbon::parse()->format('Y-m-d')) }}">Today's Advice
                        </a>
                        <!-- <a class="dropdown-item" href="{{ route('doctor.prescription.index') }}">
                            My Advice
                        </a> -->
                        <a class="dropdown-item" href="{{ route('doctor.allprescription') }}">
                            All Advice
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('doctor/frequency*')?'active':''}} {{Request::is('doctor/qtytype*')?'active':''}} {{Request::is('doctor/qty*')?'active':''}} {{Request::is('doctor/eatingtime*')?'active':''}} {{Request::is('doctor/advice*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-tasks"></i> Manage</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{Request::is('doctor/advice*')?'activated':''}}" href="{{route('doctor.advice.index')}}">Advice</a>
                    </div>
                </li>
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link" href="{{route('doctor.patient.create')}}" ><i class="ti-receipt"></i> Create Prescription</a>
                </li> -->
                <li class="nav-item dropdown {{Request::is('doctor/get-appoint*')?'active':''}}">
                    <a class="nav-link" href="{{route('doctor.get_appoint')}}">
                        @php($online_appoint = \DB::table('appt_times')->where('status',0)->where('is_declined',0)->count())
                        <i class="fa fa-stethoscope"></i> Online Appointment 
                        @if($online_appoint > 0)
                        <span class="badge badge-success" style="border-radius: 50%;">{{$online_appoint}}</span>
                        @endif
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</div>
<!-- /Menu
