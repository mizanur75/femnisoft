<div class="container top-brand">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <div class="sidebar-header"> <a href="{{Auth::user()->role->id == 1? route('admin.dashboard'):route('agent.dashboard')}}"><img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="height: 75px;"></a>
            </div>
        </div>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link">
                    <span title="Fullscreen" class="ti-fullscreen fullscreen"></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="ti-user" style="background-color: red; color: white; font-weight: bold;"></span>
                </a>
                <div class="dropdown-menu proclinic-box-shadow2 profile animated flipInY">
                    <h5>{{Auth::user()->name}}</h5>
                    <a class="dropdown-item" href="#">
                        <span class="ti-settings"></span> Settings</a>
                    <a class="dropdown-item" href="#">
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
<!-- Top Navigation -->
<!-- Menu -->
<div class="container menu-nav">
    <nav class="navbar navbar-expand-lg proclinic-bg text-white">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="ti-menu text-white"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown {{Request::is('admin/dashboard')?'active':''}}">
                    <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <span class="ti-home"></span> Dashboard</a>
                </li>
                <li class="nav-item dropdown {{Request::is('admin/patient*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-wheelchair"></i> Patients</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('admin.patient.create')}}">Add Patient</a>
                        <a class="dropdown-item" href="{{route('admin.patient.index')}}">All Patients</a>
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('admin/doctors')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-user-md"></i> Doctors</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('admin.doctors')}}">All Doctors</a>
                        <a class="dropdown-item" href="{{route('admin.chamber.index')}}">Chambers</a>
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('admin/all-payment')?'active':''}} {{Request::is('admin/appoint-payment')?'active':''}} {{Request::is('admin/appoint-payment-all')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-dollar"></i> Payments</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('admin.allpayment')}}">User Payments</a>
                        <a class="dropdown-item" href="{{route('admin.apptindex')}}">Appt. Payments</a>
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('admin/user*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-users"></i> Users</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('admin.user.index')}}">All Users</a>
                        <a class="dropdown-item" href="{{route('admin.user.create')}}">Add User</a>
                        <a class="dropdown-item" href="{{route('admin.permission')}}">User Permission</a>
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('admin/test*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-balance-scale"></i> Tests</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('admin.test.create')}}">Add Test </a>
                        <a class="dropdown-item" href="{{route('admin.test.index')}}">Test List</a>
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('admin/medicine*')?'active':''}} {{Request::is('admin/type*')?'active':''}} {{Request::is('admin/generic*')?'active':''}} {{Request::is('admin/pharmacy*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-tasks"></i> Manage</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{Request::is('admin/pharmacy*')?'activated':''}}" href="{{route('admin.pharmacy.index')}}">Pharmacy </a>
                        <a class="dropdown-item {{Request::is('admin/type*')?'activated':''}}" href="{{route('admin.type.index')}}">Type</a>
                        <a class="dropdown-item {{Request::is('admin/generic*')?'activated':''}}" href="{{route('admin.generic.index')}}">Generic</a>
                        <a class="dropdown-item {{Request::is('admin/medicine*')?'activated':''}}" href="{{route('admin.medicine.index')}}">Medicine</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><span class="ti-pencil-alt"></span> Web</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="appointments.html">Messages</a>
                        <a class="dropdown-item" href="appointments.html">Subscribers</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- /Menu
