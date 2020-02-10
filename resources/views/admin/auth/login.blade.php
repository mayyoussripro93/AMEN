@extends('admin.layouts.login_layout')
@section('content')
    <!-- BEGIN LOGIN -->
    <style>
        h3.form-title {
            color: #17ad68 !important;
        }
        .btn.green:not(.btn-outline).focus, .btn.green:not(.btn-outline):focus,
        .btn.green.uppercase, .btn.green:not(.btn-outline).active.focus, .btn.green:not(.btn-outline).active:focus, .btn.green:not(.btn-outline).active:hover, .btn.green:not(.btn-outline):active.focus, .btn.green:not(.btn-outline):active:focus, .btn.green:not(.btn-outline):active:hover, .open>.btn.green:not(.btn-outline).dropdown-toggle.focus, .open>.btn.green:not(.btn-outline).dropdown-toggle:focus, .open>.btn.green:not(.btn-outline).dropdown-toggle:hover {
            background-color: #17ad68;
            border-color: #17ad68;
        }

        .btn.green.uppercase:hover {
            background-color: #555;
            border-color: #555;
        }
    </style>
    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        <form class="form-horizontal login-form" role="form" novalidate="novalidate" method="POST"
              action="{{ route('admin.login') }}">
            {{ csrf_field() }}
            <div class="text-center">
                <img src="../images/amen_logo.png" alt="Amen" height="120">

                <h3 class="form-title font-green">Sign In</h3>
            </div>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter Email and password. </span>
            </div>
            @if ($errors->has('email'))
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span>{{ $errors->first('email') }}</span>
                </div>
            @endif
            @if ($errors->has('password'))
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span>{{ $errors->first('password') }}</span>
                </div>
            @endif
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">E-Mail Address</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
                       placeholder="Email Address" name="email" value="{{old('email')}}"/>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                       placeholder="password" name="password"/>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn green uppercase">Login</button>
                <label class="rememberme check">
                    <input type="checkbox" name="remember"/>Remember </label>
                <a class="forget-password" href="{{ route('admin.password.request') }}">Forgot Password?</a>
            </div>
        </form>
        <!-- END LOGIN FORM -->
    </div>
@endsection