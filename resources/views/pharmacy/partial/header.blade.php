<!-- Top Navigation -->

<div class="container top-brand">
    <nav class="navbar navbar-default">			
        <div class="navbar-header">
            <div class="sidebar-header"> <a href="{{route('pharmacy.dashboard')}}"><img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo"></a>
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
                    <span class="ti-user" style="background-color: red; color: white;font-weight: bold;"></span>
                </a>
                <div class="dropdown-menu proclinic-box-shadow2 profile animated flipInY">
                    <h5>{{Auth::user()->name}}</h5>
                    <a class="dropdown-item" href="{{ route('pharmacy.profile.index') }}">
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
                <li class="nav-item dropdown {{Request::is('pharmacy/dashboard*')?'active':''}}">
                    <a class="nav-link" href="{{route('pharmacy.dashboard')}}">
                    <span class="ti-home"></span> Dashboard</a>
                </li>

                <li class="nav-item dropdown {{Request::is('pharmacy/profile*')?'active':''}}">
                    <a class="nav-link" href="{{route('pharmacy.profile.index')}}" ><i class="fa fa-user"></i> Profile</a>
                </li>
                <li class="nav-item dropdown {{Request::is('pharmacy/customer*')?'active':''}} {{Request::is('pharmacy/customer*')?'active':''}} {{Request::is('pharmacy/customer*')?'active':''}} {{Request::is('pharmacy/supplier*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> Peoples</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('pharmacy.patient.index')}}">Patients</a>
                        <a class="dropdown-item" href="{{route('pharmacy.customer.index')}}"> Customers</a>
                        <a class="dropdown-item" href="{{route('pharmacy.supplier.index')}}"> Supplires</a>
                    </div>
                </li>
                <li class="nav-item dropdown {{Request::is('pharmacy/purchase*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-shopping-cart"></i> Purchase</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('pharmacy.purchase.create')}}">Create Invoice</a>
                        <a class="dropdown-item" href="{{route('pharmacy.purchase.index')}}">All Invoice</a>
                    </div>
                </li>
                <li class="nav-item {{Request::is('pharmacy/stock*')?'active':''}}">
                    <a class="nav-link" href="{{route('pharmacy.stocks')}}"><i class="fa fa-list"></i> Stock</a>
                </li>
                <li class="nav-item dropdown {{Request::is('pharmacy/sale*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-shopping-cart"></i> Sales</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('pharmacy.sale.index')}}">All Invoice</a>
                        <a class="dropdown-item" href="{{route('pharmacy.sale.create')}}">Create Order</a>
                        <a class="dropdown-item" href="{{route('pharmacy.wholesale')}}">Wholesale</a>
                    </div>
                </li>

                <li class="nav-item {{Request::is('pharmacy/cost*')?'active':''}}">
                    <a class="nav-link" href="{{route('pharmacy.cost.index')}}"><i class="fa fa-calculator"></i> Manage Costs</a>
                </li>
                <li class="nav-item dropdown {{Request::is('pharmacy/report*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bar-chart"></i> Reports</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('pharmacy.report') }}">Total Report</a>
                        <a class="dropdown-item" href="{{ route('pharmacy.today', \Carbon\Carbon::parse()->format('Y-m-d')) }}">Today Report</a>
                        <a class="dropdown-item" href="{{ route('pharmacy.yesterday', \Carbon\Carbon::yesterday()->format('Y-m-d')) }}">Yesterday Report</a>
                        <a class="dropdown-item" href="{{ route('pharmacy.weekly') }}">Weekly Report</a>
                        <a class="dropdown-item" href="{{ route('pharmacy.monthly', \Carbon\Carbon::parse()->format('Y-m')) }}">Monthly Report</a>
                        <a class="dropdown-item" href="{{ route('pharmacy.yearly', \Carbon\Carbon::parse()->format('Y')) }}">Yearly Report</a>
                        <a class="dropdown-item" href="{{ route('pharmacy.diffDate') }}">Custom Report</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- /Menu -->