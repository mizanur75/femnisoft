<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title')</title>

	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/fontawesome.min.css"/> --}}
	<!-- Fav  Icon Link -->
	<link rel="shortcut icon" type="image/png" href="{{asset('assets/images/short-icon.jpg')}}">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/fonts/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('fontawesome/css/all.css')}}">
	<!-- themify icons CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/themify-icons.css')}}">
	<!-- Animations CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
	<!-- Main CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/green.css')}}" id="style_theme">
	<link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
	<!-- morris charts -->
	<link rel="stylesheet" href="{{asset('assets/charts/css/morris.css')}}">
	<!-- jvectormap -->
	<link rel="stylesheet" href="{{asset('assets/css/jquery-jvectormap.css')}}">

	<script src="{{asset('assets/js/modernizr.min.js')}}"></script>

	<style>
		
		.translated-ltr{
			margin-top: -40px;
		}
		.goog-te-banner-frame{
			display: none;
			/* margin-top: -20px; */
		}
		.goog-logo-link{
			display: none !important;
		}
		.goog-te-gadget{
			color: transparent !important;
		}
		blink {
		  -webkit-animation: 2s linear infinite condemned_blink_effect; /* for Safari 4.0 - 8.0 */
		  animation: 2s linear infinite condemned_blink_effect;
		  color: red;
		  font-weight: bold;
		}
		.blinking{
		    animation:blinkingText 1.2s infinite;
		}
		.color-black{
			color: #020202;
		}
		@keyframes blinkingText{
		    0%{     color: #ff0000;    }
		    49%{    color: #ff0000; }
		    60%{    color: transparent; }
		    99%{    color:transparent;  }
		    100%{   color: #ff0000;    }
		}
	</style>

	@toastr_css
	@stack('css')
	<link rel="stylesheet" href="{{asset('assets/css/mystyle.css')}}">
</head>

<body>
	@php($auth = Auth::user()->role->name)
	<audio id="notify">
	  <source src="{{asset('audio/notify.ogg')}}" type="audio/ogg">
	  <source src="{{asset('audio/notify.mp3')}}" type="audio/mpeg">
	  Your browser does not support the audio element.
	</audio>
	<audio id="call">
	  <source src="{{asset('audio/calling.ogg')}}" type="audio/ogg">
	  <source src="{{asset('audio/calling.mp3')}}" type="audio/mpeg">
	  Your browser does not support the audio element.
	</audio>
	@php($current_date = now()->format('d'))
	@php($last_date = \Carbon\Carbon::now()->daysInMonth)
	<!-- Pre Loader -->
	<div class="loading">
		<div class="spinner">
			<div class="double-bounce1"></div>
			<div class="double-bounce2"></div>
		</div>
	</div>
	<!--/Pre Loader -->
	<div class="wrapper">
		<!-- Page Content -->
		<div id="content">
			@if($auth == 'Admin')
				@include('layouts.partial.header')
			@elseif($auth == 'Agent')
				@include('agent.partial.header')
			@elseif($auth == 'Doctor')
				@include('doctor.partial.header')
			@elseif($auth == 'Pharmacy')
				@include('pharmacy.partial.header')
			@elseif($auth == 'Pharma')
				@include('pharma.partial.header')
			@else
				@include('user.partial.header')
			@endif
			<!-- Breadcrumb -->

			<div class="container mt-0">
				<div class="row breadcrumb-bar">
					<div class="col-md-6">
						<h3 class="block-title">@yield('title')</h3>
					</div>
					<div class="col-md-6">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="index.html">
									<span class="ti-home"></span>
								</a>
							</li>
							<li class="breadcrumb-item active">@yield('title')</li>
						</ol>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			<!-- Main Content -->
			<div class="container home" style="min-height: 400px;">

				@yield('content')

			</div>
			<!-- /Main Content -->
			<!--Copy Rights-->
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="widget-area-2 proclinic-box-shadow pb-3 text-center pt-3">
							  <span class="text-center">Copyright <strong>©</strong>2020-{{date('Y')}} <a href="http://www.primex-bd.com/" class="font-weight-bold" target="_blank">Primex Information Systems Ltd</a>. All rights reserved.</span>
							  <!-- <button onclick="playNotify()" type="button">Play Notify</button>
							  <button onclick="pauseNotify()" type="button">Pause Notify</button>
							  <button onclick="playCall()" type="button">Play Calling</button>
							  <button onclick="pauseCall()" type="button">Pause Calling</button> --> 
						</div>
					</div>
				</div>
			</div>
			<!-- /Copy Rights-->
		</div>
		<!-- /Page Content -->
	</div>
	<!-- Back to Top -->
	<a id="back-to-top" href="#" class="back-to-top">
		<span class="ti-angle-up"></span>
	</a>
	<!-- /Back to Top -->
	<!-- Jquery Library-->
	<script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
	<!-- Popper Library-->
	<script src="{{asset('assets/js/popper.min.js')}}"></script>
	<!-- Bootstrap Library-->
	<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
	<!-- morris charts -->
	<script src="{{asset('assets/charts/js/raphael-min.js')}}"></script>
	<script src="{{asset('assets/charts/js/morris.min.js')}}"></script>
	<script src="{{asset('assets/js/custom-morris.js')}}"></script>

	<!-- Custom Script-->
	<script src="{{asset('js/sweetalert2@8.js')}}"></script>
	<script src="{{asset('js/jquery.validate.min.js')}}"></script>
	<script src="{{asset('assets/js/custom.js')}}"></script>
	@toastr_js
	@toastr_render
	@stack('scripts')
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <script>
    	function openDynWindow(){
			let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
			width=700,height=400,left=200,top=100`;

			open('{{Auth::user()->room}}', 'test', params);
    	}

    	// Call to Patient notification
    	var call = document.getElementById("call"); 

    	function playCall() { 
    	  call.play(); 
    	}

    	function pauseCall() { 
    	  call.pause();
    	}

    	// Send doctor notification
    	var notify = document.getElementById("notify"); 

    	function playNotify() { 
    	  notify.play(); 
    	}

    	function pauseNotify() { 
    	  notify.pause(); 
    	}

        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        var pusher = new Pusher('a23d080bf76032927af5', {
            cluster: 'ap2',
            forceTLS: true
        });

        var channel = pusher.subscribe('NotificationChannel');
        channel.bind('EchoEvent', function(e) {
            if( '{{ Auth::user()->id }}' == e.doctor.user_id){
                toastr.success('You have a new patient request.', {timeOut: 50000, progressBar: true, positionClass: 'toast-bottom-left', closeButton: true, newestOnTop: true, extendedTimeOut: 10000});
                playNotify();
            };
        });

        var channel = pusher.subscribe('CallingChannel');
        channel.bind('CallingEvent', function(e) {
        	var rescall = JSON.parse(e.agent);
            var authID = '{{ Auth::user()->id }}';
            if( authID == rescall.id){
            	Swal.fire({
						title: "Doctor Calling... You.",
						html: '<a href="'+rescall.room+'" onclick="openDynWindow(); pauseCall(); return false;" class="btn btn-sm btn-info">Accept</a>',
						allowOutsideClick: false,
						showConfirmButton: false,
						showCancelButton  : true,
						cancelButtonText : 'Close',
						cancelButtonColor: 'red',
					});
            	playCall();
            };
        });
        var c_date = '{{$current_date}}';
        var l_date = '{{$last_date}}';
        console.log('c'+c_date);
        console.log('l'+l_date);
        console.log(l_date - c_date);
        var payment = '{{ Auth::user()->payment }}';
		var req = "{{Request::is('go-to-pay')}}";
		if(req == 1){

		}else{
			if (l_date - c_date == 5 && payment == 2) {
				setInterval(function(){ 
					// Swal.fire({
					// 	title: "Payment Alert! \n Your Payment will Expire after 5 Days!",
					// 	allowOutsideClick: false
					// }); 
				}, 1000*60*60*5);
			}else if(l_date - c_date == 4 && payment == 2){
				setInterval(function(){ 
					// Swal.fire({
					// 	title: "Payment Alert! \n Your Payment will Expire after 4 Days!",
					// 	allowOutsideClick: false
					// }); 
				}, 1000*60*60*4);
			}else if(l_date - c_date == 3 && payment == 2){
				setInterval(function(){ 
					// Swal.fire({
					// 	title: "Payment Alert! \n Your Payment will Expire after 3 Days!",
					// 	allowOutsideClick: false
					// }); 
				}, 1000*60*60*3);
			}else if(l_date - c_date == 2 && payment == 2){
				setInterval(function(){ 
					// Swal.fire({
					// 	title: "Payment Alert! \n Your Payment will Expire after 2 Days!",
					// 	allowOutsideClick: false
					// }); 
				}, 1000*60*60*2);
			}else if(l_date - c_date == 1 && payment == 2){
				setInterval(function(){
					// Swal.fire({
					// 	title: "Payment Alert! \n Your Payment will Expire after 1 Days!",
					// 	allowOutsideClick: false
					// }); 
				}, 1000*60*60);
			}else if(l_date - c_date == 0 && payment == 2){
				setInterval(function(){ 
					// Swal.fire({
					// 	title: "Payment Alert! \n Your Payment will Expire after today!",
					// 	html: `<a href="{{route('gopay')}}" target="_blank" class="btn btn-sm btn-info">Pay Now</a>`,
					// 	allowOutsideClick: false
					// }); 
				}, 1000*60);
			}else if(l_date - c_date >= 6 && payment == 2){
				setInterval(function(){ 
					// Swal.fire({
					// 	title: `<span class="color-red">Payment Alert! \n Your Payment Expired!</span>`,
					// 	html: `<a href="{{route('gopay')}}" target="_blank" class="btn btn-sm btn-info">Pay Now</a>`,
					// 	allowOutsideClick: false
					// }); 
				}, 2000);
			}
		}
        document.onkeydown = function(e) {
	        if(e.keyCode == 123) {
	        return false;
	        }
	        if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
	        return false;
	        }
	        if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
	        return false;
	        }
	        if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
	        return false;
	        }

	        if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
	        return false;
	        }      
	    }

    </script>
    <!-- <script type="text/javascript">
		function googleTranslateElementInit() {
		  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
		}
	</script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->
</body>

</html>

