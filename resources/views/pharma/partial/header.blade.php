<!-- Top Navigation -->
<div class="container top-brand">
    <nav class="navbar navbar-default">			
        <div class="navbar-header">
            <div class="sidebar-header"> <a href="{{route('pharma.dashboard')}}"><img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="height: 75px;"></a>
            </div>
        </div>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link">
                    <span title="Fullscreen" id="google_translate_element"></span>
                </a>                            
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle bg-red" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="ti-user" style="background-color: red; color: white;font-weight: bold;"></span>
                </a>
                <div class="dropdown-menu proclinic-box-shadow2 profile animated flipInY">
                    <h5>{{Auth::user()->name}}</h5>
                    <a class="dropdown-item" href="{{route('pharma.profile.index')}}">
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
                <li class="nav-item dropdown {{Request::is('pharma/dashboard*')?'active':''}}">
                    <a class="nav-link" href="{{route('pharma.dashboard')}}">
                    <span class="ti-home"></span> Dashboard</a>
                </li>
                <li class="nav-item dropdown {{Request::is('pharma/profile*')?'active':''}}">
                    <a class="nav-link" href="{{route('pharma.profile.index')}}">
                    <span class="fa fa-user-circle"></span> Profile</a>
                </li>
                <li class="nav-item dropdown {{Request::is('pharma/price*')?'active':''}}">
                    <a class="nav-link" href="{{route('pharma.price.index')}}">
                    <span class="fa fa-money"></span> Pricing</a>
                </li>
                <li class="nav-item dropdown {{Request::is('pharma/medicine*')?'active':''}} {{Request::is('pharma/type*')?'active':''}} {{Request::is('pharma/generic*')?'active':''}} {{Request::is('pharma/measurement*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-tasks"></i> Manage</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{Request::is('pharma/type*')?'activated':''}}" href="{{route('pharma.type.index')}}">Type/Formulation</a>
                        <a class="dropdown-item {{Request::is('pharma/generic*')?'activated':''}}" href="{{route('pharma.generic.index')}}">Generic</a>
                        <a class="dropdown-item {{Request::is('pharma/measurement*')?'activated':''}}" href="{{route('pharma.measurement.index')}}">Measurement/Dosage</a>
                        <a class="dropdown-item {{Request::is('pharma/medicine*')?'activated':''}}" href="{{route('pharma.medicine.index')}}">Medicine/Trade Name</a>
                    </div>
                </li>
                
            </ul>
        </div>
    </nav>
</div>
<!-- /Menu -->