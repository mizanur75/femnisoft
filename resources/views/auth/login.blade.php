<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome to Login</title>
        <link rel="shortcut icon" href="{{asset('icon.png')}}" />
        <link href="{{asset('assets/login/bootstrap.min.css')}}" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
        <style type="text/css">
            body {
                    background: #dadada !important;
                    }
                    .card {
                        /*border: 1px solid #0264af;*/
                    }
                    .card-login {
                        margin-top: 130px;
                        padding: 18px;
                        max-width: 30rem;
                    }

                    .card-header {
                        color: #fff;
                        font-family: sans-serif;
                        font-size: 20px;
                        font-weight: 600 !important;
                        margin-top: 10px;
                        border-bottom: 0;
                    }

                    .input-group-prepend span{
                        width: 50px;
                        background-color: #ff0000;
                        color: #fff;
                        border:0 !important;
                    }

                    input:focus{
                        outline: 0 0 0 0  !important;
                        box-shadow: 0 0 0 0 !important;
                    }

                    .login_btn{
                        width: 130px;
                    }

                    .login_btn:hover{
                        color: #fff;
                        background-color: #ff0000;
                    }

                    .btn-outline-danger {
                        color: #fff;
                        font-size: 18px;
                        background-color: #28a745;
                        background-image: none;
                        border-color: #28a745;
                    }

                    .form-control {
                        display: block;
                        width: 100%;
                        height: calc(2.25rem + 2px);
                        padding: 0.375rem 0.75rem;
                        font-size: 1.2rem;
                        line-height: 1.6;
                        color: #28a745;
                        background-color: transparent;
                        background-clip: padding-box;
                        border: 1px solid #5269d0;
                        border-radius: 0;
                        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                    }

                    .input-group-text {
                        display: -ms-flexbox;
                        display: flex;
                        -ms-flex-align: center;
                        align-items: center;
                        padding: 0.375rem 0.75rem;
                        margin-bottom: 0;
                        font-size: 1.5rem;
                        font-weight: 700;
                        line-height: 1.6;
                        color: #495057;
                        text-align: center;
                        white-space: nowrap;
                        background-color: #e9ecef;
                        border: 1px solid #ced4da;
                        border-radius: 0;
                    }
                    .bg-dark{
                        background-color: #ffffff !important;
                    }
                    .input-group-prepend span{
                        background-color: #5269d0;
                    }
                    .image-logo{
                        width: 36%;
                    }
                    .middle-border{
                        border-bottom: 1px solid #0264af; margin-left: -20px; margin-right: -20px;
                    }
                    .ems{
                        color: #868686;
                        font-weight: bolder;
                        border: 3px solid #0264af;
                        border-radius: 11px;
                        padding: 8px;
                        margin: 0px auto;
                        width: 130px;
                        text-shadow: 0px 1px, 1px 0px, 1px 1px;
                    }
                    .logo-title{
                        color: #EF4E23;
                        font-size: 24px;
                        margin-top: 7px;
                        font-weight: bolder;
                        /*text-shadow: 0px 1px, 1px 0px, 1px 1px;*/
                    }
                    .power{
                        /*margin-top: 10px;*/
                        font-size: 13px;
                    }
                    .card-body{
                        padding: 0 1.25rem 1.25rem 1.25rem
                    }
                    .container {
                        width: 30%;
                    }
                    @media(max-width: 768px) {
                        .power{
                            margin-top: 0px;
                            font-size: 13px;
                        }
                        .ems{
                            width: 111px;
                            font-size: 30px;
                            padding: 4px 4px;
                            text-shadow: 0px 1px, 1px 0px, 1px 1px;
                        }
                        .logo-title{
                            font-size: 15px;
                            text-shadow: none;
                        }
                        .card-body{
                            padding: 0;
                        }
                        .container {
                            width: 100%;
                        }
                    }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card card-login mx-auto text-center bg-dark">
                <div class="card-header mx-auto bg-dark">
                    <div>
                        <img src="{{asset('assets/images/logo-dark.png')}}" class="img-fluid img-responsive" alt="Logo">
                        <!-- <h1 class="ems">EMS</h1> -->
                    </div>
                    {{--<div class="logo-title"> EASY DOCTOR </div>--}}


                </div>
                <div class="card-body">
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="text" name="email" class="form-control" placeholder="Enter Email">
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        @if ($errors->has('email'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            <input type="submit" name="btn" value="Login" class="btn btn-danger float-right login_btn" style="background-color: #4d5afb !important; border-color: #4d5afb;">
                        </div>
                        <div class="row">
                            <span class="power">Powered by <a href="https://primex-bd.com" target="_blank">Primex Information System Ltd</a></span>
                        </div>

                    </form>
                </div>
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
    function goback(){
        document.getElementById("goback").href = "";
    }
    </script>
</html>
