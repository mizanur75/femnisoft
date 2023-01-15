<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome to Login</title>
        <link rel="shortcut icon" href="{{asset('icon.png')}}" />
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
    </head>
    <body>
        <div class="body">
            <div class="mobile">
                
                @guest
                <div class="head">
                    <h1 class="title">Welcome to <span style="color:#00711D;">LOGIN</span></h1>
                </div>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <input class="input" type="text" name="email" placeholder="Enter Your Email">
                    <input class="input" type="password" name="password" placeholder="Enter Your Password">  <br>
                    <div style="margin:7px 0px;">
                        @if ($errors->has('email'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        <div class="div-login"><input type="submit" value="Sign In" name="btnLogin" class="login"></div>
                    </div>
                </form>
                @else
                <h1>
                    @if(Auth::user()->id == 1)
                    <a href="{{route('admin.dashboard')}}" class="btn btn-primary btn-block">Dashboard</a>
                    @elseif(Auth::user()->id == 2)
                    <a href="{{route('agent.dashboard')}}" class="btn btn-primary btn-block">Dashboard</a>
                    @elseif(Auth::user()->id == 3)
                    <a href="{{route('doctor.dashboard')}}" class="btn btn-primary btn-block">Dashboard</a>
                    @elseif(Auth::user()->id == 4)
                    <a href="{{route('pharmacy.dashboard')}}" class="btn btn-primary btn-block">Dashboard</a>
                    @else
                    <a href="{{route('user.dashboard')}}" class="btn btn-primary btn-block">Dashboard</a>
                    @endif
                </h1>
                @endguest
            </div>
        </div>
    </body>
    <script>
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
</html>
