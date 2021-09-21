<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Mukta');

        body {
            font-family: 'Mukta', sans-serif;
            height: 100vh;
            min-height: 550px;
            background-image: url(https://img.wallpapersafari.com/desktop/1440/900/26/92/0KH5pV.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .text-secondary{
            color:#afa9a9 !important;
        }

        a {
            text-decoration: none;
            color: #444444;
        }

        .text-secondary:hover{
            color:#837f7f !important;
        }

        .login-reg-panel {
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
            width: 70%;
            right: 0;
            left: 0;
            margin: auto;
            height: 400px;
            background-color: rgba(30, 30, 30, 0.9);
        }

        .white-panel {
            background-color: rgba(255, 255, 255, 1);
            height: 500px;
            position: absolute;
            top: -50px;
            width: 50%;
            right: calc(50% - 50px);
            transition: .3s ease-in-out;
            z-index: 0;
        }

        .login-reg-panel input[type="radio"] {
            position: relative;
            display: none;
        }

        .login-reg-panel {
            color: #B8B8B8;
        }

        .login-reg-panel #label-login,
        .login-reg-panel #label-register {
            border: 1px solid #9E9E9E;
            padding: 0 5px;
            width: 150px;
            display: block;
            text-align: center;
            border-radius: 3px;
            cursor: pointer;
        }

        .login-info-box {
            width: 30%;
            padding: 0 50px;
            top: 20%;
            left: 0;
            position: absolute;
            text-align: left;
        }

        .register-info-box {
            width: 30%;
            padding: 0 50px;
            top: 20%;
            right: 0;
            position: absolute;
            text-align: left;

        }

        .right-log {
            right: 50px !important;
        }

        .login-show,
        .register-show {
            z-index: 1;
            display: none;
            opacity: 0;
            transition: 0.3s ease-in-out;
            color: #242424;
            text-align: left;
            padding: 50px;
        }

        .show-log-panel {
            display: block;
            opacity: 0.9;
        }

        .login-show input[type="text"],
        .login-show input[type="password"] {
            width: 100%;
            display: block;
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #b5b5b5;
            outline: none;
        }

        .login-show input[type="submit"] {
            max-width: 150px;
            width: 100%;
            background: #444444;
            color: #f9f9f9;
            border: none;
            padding: 10px;
            text-transform: uppercase;
            border-radius: 2px;
            float: right;
            cursor: pointer;
        }

        .login-show a {
            display: inline-block;
            padding: 10px 0;
        }

        .register-show input[type="text"],
        .register-show input[type="password"] {
            width: 100%;
            display: block;
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #b5b5b5;
            outline: none;
        }

        .register-show input[type="submit"] {
            max-width: 150px;
            width: 100%;
            background: #444444;
            color: #f9f9f9;
            border: none;
            padding: 10px;
            text-transform: uppercase;
            border-radius: 2px;
            float: right;
            cursor: pointer;
        }

        .credit {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: #3B3B25;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;
            z-index: 99;
        }

        a {
            text-decoration: none;
            color: #eaeaea;
        }
    </style>
</head>

<body>
    <div class="login-reg-panel">
        <div class="login-info-box">
            <h2>Have an account?</h2>
            <p>Lorem ipsum dolor sit amet</p>
            <label id="label-register" for="log-reg-show">Login</label>
            <input type="radio" name="active-log-panel" id="log-reg-show" checked="checked">
        </div>

        <div class="register-info-box">
            <h2>Don't have an account?</h2>
            <p>Lorem ipsum dolor sit amet</p>
            <label id="label-login" for="log-login-show">Register</label>
            <input type="radio" name="active-log-panel" id="log-login-show">
        </div>

        <div class="white-panel">
            <div class="login-show">
                <h2>LOGIN</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <label for="email" value="{{__('Email')}}"></label>
                    <input type="text" id="email" name="email" placeholder="Email" :value="old('email')" required
                        autofocus>

                    <label for="password" value="{{ __('Password') }}"></label>
                    <input id="password" type="password" placeholder="Password" name="password" required
                    autocomplete="current-password" >

                    <div class="flex items-center justify-end mt-4">
                        {{-- @if (Route::has('password.request'))
                        <a class="text-secondary"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                        @endif --}}
                        <input type="submit" value="Login" >
                    </div>
                </form>
            </div>
            <div class="register-show">
                <h2>REGISTER</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <label for="name" value="{{ __('Name') }}"></label>
                    <input type="text" id="name" name="name" placeholder="Name" :value="old('name')" required
                        autofocus autocomplete="name">

                    <label for="email" value="{{__('Email')}}"></label>
                    <input type="text" id="email" name="email" placeholder="Email" :value="old('email')" required
                        autofocus>

                    <label for="password" value="{{__('Password')}}"></label>
                    <input id="password" type="password" placeholder="Password" name="password" required autocomplete="new-password">
                    
                    <label for="password_confirmation" value="{{__('Confirm Password')}}"></label>
                    <input id="password_confirmation" type="password" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
                    
                    <input type="submit" value="Register">
                </form>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"
    integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('.login-info-box').fadeOut();
        $('.login-show').addClass('show-log-panel');
    });

    $('.login-reg-panel input[type="radio"]').on('change', function() {
        if($('#log-login-show').is(':checked')) {
            $('.register-info-box').fadeOut(); 
            $('.login-info-box').fadeIn();
            
            $('.white-panel').addClass('right-log');
            $('.register-show').addClass('show-log-panel');
            $('.login-show').removeClass('show-log-panel');
            
        }
        else if($('#log-reg-show').is(':checked')) {
            $('.register-info-box').fadeIn();
            $('.login-info-box').fadeOut();
            
            $('.white-panel').removeClass('right-log');
            
            $('.login-show').addClass('show-log-panel');
            $('.register-show').removeClass('show-log-panel');
        }
    });
</script>
</html>