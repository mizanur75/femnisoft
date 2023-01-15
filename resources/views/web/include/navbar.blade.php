<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="/"><img style="height: 63px;" src="{{asset('web/images/Logo.png')}}"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="/" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="{{route('about')}}" class="nav-link">WHO AM I</a></li>
          <li class="nav-item"><a href="{{route('team')}}" class="nav-link">TEAM</a></li>
          <li class="nav-item"><a href="{{route('services')}}" class="nav-link">SERVICES</a></li>
          <li class="nav-item"><a href="{{route('blog')}}" class="nav-link">BLOG</a></li>
          <li class="nav-item"><a href="{{route('faq')}}" class="nav-link">FAQ</a></li>
          <li class="nav-item cta"><a href="javascript:void(0)" class="nav-link" data-toggle="modal" data-target="#modalRequest"><span>Make an Appointment</span></a></li>
        </ul>
      </div>
    </div>
</nav>